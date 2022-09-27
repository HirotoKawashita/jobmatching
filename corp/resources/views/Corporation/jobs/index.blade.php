<link rel="stylesheet" href="{{ asset('/css/job/style.scss')}}">
<script type="module" src="{{ asset('/js/job/main.js') }}"></script>

@include('Element.global_menu')
<div class="companyInformation">
    @if (session('flash_message'))
    <div class="flash_message">
        {{ session('flash_message') }}
    </div>
    @endif
    <div class="companyInformation_header">
        <div class="sort">
            <select name="sort" id="sort">
                <option value="">新着順</option>
                <option value="">B</option>
                <option value="">C</option>
            </select>
        </div>
        <div class="jobAdd">
            <a href="{{route('jobs.add', ['page' => $currentPage])}}">＋</a>
        </div>
    </div>
    @if (empty($entities))
    <p class="text-muted text-center"><?= __('登録されていません。') ?></p>
    @else
    @foreach ($entities as $entity)
    <div class="companyContent">
        <div class="companyImg">
            <a href="">
                <img src="{{ $entity->image_path != null ? asset(decodeImagePath($entity)) : asset('images/IMG_0307.jpeg') }}" alt="">
            </a>
        </div>
        <div class="companyIntroduction">
            <p class="profession">職種：<span>{{ $entity->occupation ? $entity->occupation->name : ''}}</span></p>
            <p>仕事内容：<span>{{ $entity['business_content'] }}</span></p>
            <p>雇用形態：<span>{{ $employmentFormOptios[$entity['employment_form']] }}</span></p>
            <p>採用予定人数：<span>{{ $entity['hired_people_no'] }}</span>人</p>
            <p>勤務地：<span>{{ $entity['work_location'] }}</span></p>
            <p>月給：<span>{{ number_format($entity['salary']) }}</span>円</p>
        </div>
        <p class="companyFeature">{{ $entity->tag ? $entity->tag->name : ''}}</p>
        <div class="studentEntry_btn">
            <a href="{{ route('jobs.edit', ['id' => $entity['id'], 'page' => $currentPage]) }}"><img src="{{ asset('images/setting_chenge_app.png') }}" alt=""></a>
            <!-- 削除ボタン -->
            <form action="{{ route('jobs.delete', ['id' => $entity['id'], 'page' => $currentPage]) }}" method="post">
                <input class="btn btn-default delete-btn" type="button" value="<?= __('削除') ?>" />
                @method('delete')
                @csrf
            </form>
        </div>
    </div>
    @endforeach
    @endif
    {{ $entities->links('vendor.pagination.tailwind') }}
</div>