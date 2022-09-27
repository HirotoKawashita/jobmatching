<?php
use App\Models\Job;
namespace App\Services\Corporation;

use App\Services\Common\BaseService;
use App\Models\Job;
use App\Services\Resource\OccupationsService;
use App\Services\Resource\TagsService;

use Illuminate\Support\Facades\DB;



class JobsService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new Job);
    }

    public function findBy($data = [], $options = []) {
        $entity = $this->entity;

        if (!empty($data['name'])) {
            $entity = $entity->where('name', 'like', $data['name'].'%');
        }

        if (!empty($data['type'])) {
            $entity = $entity->where('type', $data['type']);
        }

        return $entity;
    }

    public function getById($id, $options = []) {
        $entity = $this->entity->where('id', $id);
        return $entity->first();
    }

    public function getByType($type) {
        $entity = $this->entity->where('type', $type)->first();
        return $entity;
    }

    public function getEmploymentFormOptios() {
        $options = [
            '0' => '選択してください',
            '1' => '正社員',
            '2' => '契約社員',
            '3' => '派遣社員',
            '4' => 'パート・アルバイト'
        ];
        return $options;
    }

    public function getBonusOptios() {
        $options = [
            '0' => '無し',
            '1' => '有り'
        ];
        return $options;
    }

    public function getTransferOptios() {
        $options = [
            '0' => '無し',
            '1' => '有り'
        ];
        return $options;
    }

    public function getOccupationOptions() {
        try {
            $occupation = new OccupationsService();
            $occupations = $occupation->findBy([])
            ->pluck('name', 'id')->toArray();
            array_unshift($occupations, '選択してください');

        } catch (\Exception $e) {
            \Log::error($e);
            return false;
        }
        
        return $occupations;
    }

    public function getTagOptions() {
        try {
            $tag = new TagsService();
            $tags = $tag->findBy([])
            ->pluck('name', 'id')->toArray();
            array_unshift($tags, '選択してください');

        } catch (\Exception $e) {
            \Log::error($e);
            return false;
        }
        
        return $tags;
    }


    public function getInsertId() {
        $lastId = DB::select('SELECT id FROM jobs ORDER BY id DESC LIMIT 1')[0]->id;
        $insertId = $lastId += 1;

        return $insertId;
    }

}

