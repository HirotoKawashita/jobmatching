<?php

namespace App\Http\Controllers\Corporation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Http\Requests\JobsRequest;
use App\Http\Controllers\Controller;
use App\Services\Corporation\JobsService;
use App\Services\Common\Image\GenerateImageService;
use App\Services\Common\Image\DestroyImageService;


use Illuminate\Session\TokenMismatchException;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Exception\NotWritableException;
use Illuminate\Http\Exceptions\PostTooLargeException;

class JobsController extends Controller
{
    private $job;
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(JobsService $job, GenerateImageService $gImage, DestroyImageService $dImage)
    {
        parent::__construct();
        $this->job = $job;
        $this->gImage = $gImage;
        $this->dImage = $dImage;
    }

    public function index(Request $request)
    {
        // $jobs = $this->job->findBy([])->paginate(5);

        !$request->isMethod('GET') ? abort(500, '不正なリクエストです')
            : $entities = $this->job->findBy([], ['contain' => ['occupation', 'tag']])->paginate(10);
        !$entities ? abort(500, 'データが存在しません')
        : $employmentFormOptios = $this->job->getEmploymentFormOptios();
        $currentPage = $request->page;
        // dd($entities);
        return view('Corporation.jobs.index', compact('entities','employmentFormOptios', 'currentPage'));
    }

    public function add(JobsRequest $request)
    {
        $entity = null;
        
        // セッション初期化、追加完了時のページ保持
        if (!$request->session()->has('page') || null != $request->page && $request->session()->get('page') != $request->page) {
            $request->session()->regenerate();
            $request->session()->put('page', $request->page);
        }

        $currentPage = $request->page;

        if ($request->isMethod('POST')) {
            $data = $request->all();
            // dd($data);

            try {
                // 多重送信防止
                if (!Cache::add('used_token.' . $request->session()->token(), 1, 1)) {
                    # 使用済みだったときの処理
                    # TokenMismatchExceptionを投げる(CSRFトークン不一致の扱いにする)
                    throw new TokenMismatchException();
                }
            } catch (\Exception $e) {
                abort(500, 'トークンが不正です');
            }

            // 画像保存
            if (isset($data) && !empty($data['image_path'])) {
                try {
                 
                    $fileName = $data['image_path']->getClientOriginalName();
             
                    if (!$fileName) {
                        throw new \Exception();
                    }
                    // var_dump("lkdie");
                    // exit;
                    $savePaths = $this->gImage->__construct('job', $this->job->getInsertId(), $data['image_path'], $fileName);
                
                    if (empty($savePaths)) {
                        throw new \Exception();
                    }
                    $data['image_path'] = json_encode($savePaths);

                } catch (NotReadableException $e) {
                    abort(500, 'ファイルを読み込めませんでした');
                } catch (NotWritableException $e) {
                    try {
                        $this->dImage->__construct('job', $savePaths);
                    } catch (\Exception $e) {
                        abort(500, 'ファイルを削除できませんでした');
                    }
                    abort(500, 'ファイルを書き込めませんでした');
                } catch (PostTooLargeException $e) {
                    abort(500, 'ファイルサイズが大きすぎます');
                } catch (\Exception $e) {
                    try {
                        $this->dImage->__construct('job', $savePaths);
                    } catch (\Exception $e) {
                        abort(500, 'ファイルを削除できませんでした');
                    }
                    abort(500, '予期せぬエラーが発生しました');
                }
            }
            
            $result = false;

            isset($data) && array_key_exists('occupation_id', $data)
            && array_key_exists('business_content', $data) && array_key_exists('employment_form', $data) && array_key_exists('hired_people_no', $data) && array_key_exists('test_period', $data)
            && array_key_exists('working_start_time', $data) && array_key_exists('working_end_time', $data) && array_key_exists('overtime_hours', $data) && array_key_exists('is_transfer', $data) && array_key_exists('salary', $data) && array_key_exists('is_bonus', $data)
            && array_key_exists('various_allowances', $data) && array_key_exists('contract_period', $data) && array_key_exists('welfare', $data) && array_key_exists('tag_id', $data)
            && array_key_exists('status', $data) && array_key_exists('approval_status', $data)
            ? $result = $this->job->save($entity, $data)
            : abort(500, 'パラメータが不正です');
            $result = $this->job->save($entity, $data);

            // var_dump($data);
            // echo '<hr>';s
            // var_dump($result);
            // exit;

            if(!$result) {
                try {
                    $this->dImage->__construct('job', $savePaths);
                } catch (\Exception $e) {
                    abort(500, 'ファイルを削除できませんでした');
                }
                abort(500, 'データを保存できませんでした');
            }

            $currentPage = $request->session()->get('page');
            $request->session()->forget('page');

            // トークンを再生成
            $request->session()->regenerateToken();
            return redirect()->route('jobs.index', ['page' => $currentPage])->with('flash_message', '保存しました');
        }
        

        $isAdd = preg_match('/add/', url()->current()) === 1;
        $employmentFormOptios = $this->job->getEmploymentFormOptios();
        $occupationOptions = $this->job->getOccupationOptions();
        $tagOptions = $this->job->getTagOptions();
        $transferOptios = $this->job->getTransferOptios();
        $bonusOptios = $this->job->getBonusOptios();
        if (!$employmentFormOptios || !$occupationOptions) abort(500, '値を取得できませんでした');
        
        return view('Corporation.jobs.form', compact('entity', 'employmentFormOptios', 'bonusOptios','occupationOptions', 'transferOptios', 'tagOptions', 'isAdd', 'currentPage'));

}

    public function edit(Request $request)
    {
        $entity = null;
        // セッション初期化、編集完了時のページ保持
        if (!$request->session()->has('page') || null != $request->page && $request->session()->get('page') != $request->page) {
            $request->session()->regenerate();
            $request->session()->put('page', $request->page);
        }
        $currentPage = $request->page;

        // todo ログインIDに属するIDでないものをエラーで弾く

        !$request->id ? abort(404, 'データが見つかりませんでした')
        : !is_numeric($request->id) ? abort(500, 'パラメータが不正です')
        : $entity = $this->job->getById($request->id);
        if (!$entity) abort(500, 'データが存在しません');

        if ($request->isMethod('POST')) {
            $data = $request->all();
            try {
                // 多重送信防止
                if (!Cache::add('used_token.'.$request->session()->token(), 1, 1)) {
                    # 使用済みだったときの処理
                    # TokenMismatchExceptionを投げる(CSRFトークン不一致の扱いにする)
                    throw new TokenMismatchException();
                }
            } catch (\Exception $e) {
                abort(500, 'トークンが不正です');
            }

            // 画像保存
            if (isset($data) && !empty($data['image_path'])) {
                try {
                    $fileName = $data['image_path']->getClientOriginalName();
                    if (!$fileName) {
                        throw new \Exception();
                    }
                    $savePaths = $this->gImage->__construct('sample', $request->id, $data['image_path'], $fileName);

                    if (empty($savePaths)) {
                        throw new \Exception();
                    }
                    $data['image_path'] = json_encode($savePaths);


                } catch (NotReadableException $e) {
                    abort(500, 'ファイルを読み込めませんでした');
                } catch (NotWritableException $e) {
                    try {
                        $this->dImage->__construct('sample', $savePaths);
                    } catch (\Exception $e) {
                        abort(500, 'ファイルを削除できませんでした');
                    }
                    abort(500, 'ファイルを書き込めませんでした');
                } catch (PostTooLargeException $e) {
                    abort(500, 'ファイルサイズが大きすぎます');
                } catch (\Exception $e) {
                    try {
                        $this->dImage->__construct('sample', $savePaths);
                    } catch (\Exception $e) {
                        abort(500, 'ファイルを削除できませんでしたs');
                    }
                    abort(500, '予期せぬエラーが発生しました');
                }
            }

            $result = false;
            isset($data) && array_key_exists('occupation_id', $data)
            && array_key_exists('business_content', $data) && array_key_exists('employment_form', $data) && array_key_exists('hired_people_no', $data) && array_key_exists('test_period', $data)
            && array_key_exists('working_start_time', $data) && array_key_exists('working_end_time', $data) && array_key_exists('overtime_hours', $data) && array_key_exists('is_transfer', $data) && array_key_exists('salary', $data) && array_key_exists('is_bonus', $data)
            && array_key_exists('various_allowances', $data) && array_key_exists('contract_period', $data) && array_key_exists('welfare', $data) && array_key_exists('tag_id', $data)
            && array_key_exists('status', $data) && array_key_exists('approval_status', $data)
            ? $result = $this->job->save($entity, $data)
            : abort(500, 'パラメータが不正です');
            if(!$result) abort(500, 'データを保存できませんでした');

            $currentPage = $request->session()->get('page');
            $request->session()->forget('page');

            // トークンを再生成
            $request->session()->regenerateToken();
            return redirect()->route('jobs.index', ['page' => $currentPage])->with('flash_message', '保存しました');
        }

        if (!$request->isMethod('GET')) abort(500, '不正なリクエストです');
        $employmentFormOptios = $this->job->getEmploymentFormOptios();
        $occupationOptions = $this->job->getOccupationOptions();
        $tagOptions = $this->job->getTagOptions();
        $transferOptios = $this->job->getTransferOptios();
        $bonusOptios = $this->job->getBonusOptios();
        if (!$employmentFormOptios || !$occupationOptions) abort(500, '値を取得できませんでした');
        $isAdd = preg_match('/add/', url()->current()) === 1;


        if (!empty($entity['image_path'])) {
            $entity['image_path'] = json_decode($entity['image_path'], true);
        }

        return view('Corporation.jobs.form', compact('entity', 'employmentFormOptios', 'bonusOptios','occupationOptions', 'transferOptios', 'tagOptions', 'isAdd', 'currentPage'));

    }

    public function view(Request $request)
    {
    }

   // 削除
   public function delete(Request $request)
   {
       try {
           // 多重送信防止
           if (!Cache::add('used_token.'.$request->session()->token(), 1, 1)) {
               # 使用済みだったときの処理
               # TokenMismatchExceptionを投げる(CSRFトークン不一致の扱いにする)
               throw new TokenMismatchException();
           }
       } catch (\Exception $e) {
           abort(500, 'トークンが不正です');
       }
       // todo ログインIDに属するIDでないものをエラーで弾く

       !$request->isMethod('DELETE') ? abort(500, '不正なリクエストです')
       : !$request->id ? abort(404, 'データが見つかりませんでした')
       : !is_numeric($request->id) ? abort(500, 'パラメータが不正です')
       : $entity = $this->job->getById($request->id);
         !$entity ? abort(500, 'データが存在しません')
       : $result = false;
         $result = $this->job->delete($entity);
         if(!$result) abort(500, 'データを削除できませんでした');

         // トークンを再生成
         $request->session()->regenerateToken();
         return redirect()->route('jobs.index', ['page' => $request->page])->with('flash_message', '削除しました');
   }
}
