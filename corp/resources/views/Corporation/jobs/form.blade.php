<link rel="stylesheet" href="{{ asset('/css/job/style.scss')}}">
<script type="module" src="{{ asset('/js/job/main.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/vendor/tingle.min.css') }}">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

@include('Element.global_menu')
<h2 class="studentDetail_taitle">求人登録申請</h2>

    @if ($isAdd)
      {{ Form::open(['route' => 'jobs.add', 'files' => true]) }}
    @else
      {{ Form::open(['route' => ['jobs.edit', ['id' => Request::get('id')]], 'files' => true]) }}
    @endif
    @csrf


        <div class="corporationDetail">
            <div class="corporationImg">
                <div class="form-group">
                    <div class="col-sm-2 corporation-box">
                    <label class="form-label"><?= __('画像アップロード') ?></label>
                    </div>
                    {{ Form::file('image_path') }}
                </div>
                <div class="upload-image">
                    @if ($entity['image_path'])
                    <img class="job-image" src="{{ asset($entity['image_path']['small']) }}" alt="">
                    @endif
                </div>
            </div>
            <div class="corporationDtail_introduction">
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('職種') ?></label>
                </div>
                {{ Form::select('occupation_id', $occupationOptions, old('occupation_id') ? old('occupation_id') : $entity['occupation_id'] ? $entity['occupation_id'] : null, ['class' => 'form-control']) }}
                <p class="error-messaage v_occupation_id">
                    @if ($errors->has('occupation_id'))
                    <?= $errors->first('occupation_id'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('仕事内容') ?></label>
                </div>
                {{ Form::textarea('business_content', old('business_content') ? old('business_content') : $entity['business_content'] ? $entity['business_content'] : '', ['class' => 'form-control', 'maxlength' => 150]) }}
                <p class="error-messaage v_name">
                    @if ($errors->has('business_content'))
                    <?= $errors->first('business_content'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('雇用形態') ?></label>
                </div>
                {{ Form::select('employment_form', $employmentFormOptios, old('employment_form') ? old('employment_form') : $entity['employment_form'] ? $entity['employment_form'] : null, ['class' => 'form-control']) }}
                <p class="error-messaage v_corporation_id">
                    @if ($errors->has('employment_form'))
                    <?= $errors->first('employment_form'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('採用予定人数') ?></label>
                </div>
                {{ Form::number('hired_people_no', old('hired_people_no') ? old('hired_people_no') : $entity['hired_people_no'] ? $entity['hired_people_no'] : '', ['class' => 'form-control form-number', 'type' => 'number', 'maxlength' => 10]) }} 人
                <p class="error-messaage v_hired_people_no">
                    @if ($errors->has('hired_people_no'))
                    <?= $errors->first('hired_people_no'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('試用期間') ?></label>
                </div>
                {{ Form::number('test_period', old('test_period') ? old('test_period') : $entity['test_period'] ? $entity['test_period'] : '', ['class' => 'form-control form-time', 'type' => 'number', 'maxlength' => 10]) }} ヶ月
                <p class="error-messaage v_test_period">
                    @if ($errors->has('test_period'))
                    <?= $errors->first('test_period'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('契約期間') ?></label>
                </div>
                {{ Form::text('contract_period', old('contract_period') ? old('contract_period') : $entity['contract_period'] ? $entity['contract_period'] : '', ['class' => 'form-control form-time', 'id' => 'contract_period', 'maxlength' => 30]) }} ヶ月
                <p class="error-messaage v_contract_period">
                    @if ($errors->has('contract_period'))
                    <?= $errors->first('contract_period'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('勤務時間') ?></label>
                </div>
                {{ Form::time('working_start_time', old('working_start_time') ? old('working_start_time') : $entity['working_start_time'] ? $entity['working_start_time'] : '', ['class' => 'form-control form-time', 'id' => 'working_start_time', 'maxlength' => 30]) }} ~
                {{ Form::time('working_end_time', old('working_end_time') ? old('working_end_time') : $entity['working_end_time'] ? $entity['working_end_time'] : '', ['class' => 'form-control form-time', 'id' => 'working_end_time', 'maxlength' => 30]) }}
                <p class="error-messaage v_name">
                    @if ($errors->has('working_start_time'))
                    <?= $errors->first('working_start_time'); ?>
                    @endif
                </p>
                <p class="error-messaage v_name">
                    @if ($errors->has('working_end_time'))
                    <?= $errors->first('working_end_time'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('残業時間') ?></label>
                </div>
                {{ Form::number('overtime_hours', old('overtime_hours') ? old('overtime_hours') : $entity['overtime_hours'] ? $entity['overtime_hours'] : '', ['class' => 'form-control form-time', 'id' => 'overtime_hours', 'maxlength' => 30]) }} 時間
                <p class="error-messaage v_overtime_hours">
                    @if ($errors->has('overtime_hours'))
                    <?= $errors->first('overtime_hours'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('転職有無') ?></label>
                </div>
                {{ Form::select('is_transfer', $transferOptios, old('is_transfer') ? old('is_transfer') : $entity['is_transfer'] ? $entity['is_transfer'] : '', ['class' => 'form-control', 'id' => 'is_transfer']) }}
                <p class="error-messaage v_name">
                    @if ($errors->has('is_transfer'))
                    <?= $errors->first('is_transfer'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('給与') ?></label>
                </div>
                {{ Form::number('salary', old('salary') ? old('salary') : $entity['salary'] ? $entity['salary'] : '', ['class' => 'form-control form-time', 'id' => 'salary', 'maxlength' => 30]) }} 万円
                <p class="error-messaage v_salary">
                    @if ($errors->has('salary'))
                    <?= $errors->first('salary'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('昇給・賞与') ?></label>
                </div>
                {{ Form::select('is_bonus', $bonusOptios, old('is_bonus') ? old('is_bonus') : $entity['is_bonus'] ? $entity['is_bonus'] : null, ['class' => 'form-control']) }}
                <p class="error-messaage v_is_bonus">
                    @if ($errors->has('is_bonus'))
                    <?= $errors->first('is_bonus'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('諸手当') ?></label>
                </div>
                {{ Form::text('various_allowances', old('various_allowances') ? old('various_allowances') : $entity['various_allowances'] ? $entity['various_allowances'] : '', ['class' => 'form-control', 'id' => 'various_allowances', 'maxlength' => 30]) }}
                <p class="error-messaage v_various_allowances">
                    @if ($errors->has('various_allowances'))
                    <?= $errors->first('various_allowances'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('福利厚生') ?></label>
                </div>
                {{ Form::text('welfare', old('welfare') ? old('welfare') : $entity['welfare'] ? $entity['welfare'] : '', ['class' => 'form-control', 'id' => 'welfare', 'maxlength' => 30]) }}
                <p class="error-messaage v_welfare">
                    @if ($errors->has('welfare'))
                    <?= $errors->first('welfare'); ?>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <div class="col-sm-1 name-box">
                    <label class="form-check-label"><?= __('会社の特徴') ?></label>
                </div>
                {{ Form::select('tag_id', $tagOptions, old('tag_id') ? old('tag_id') : $entity['tag_id'] ? $entity['tag_id'] : null, ['class' => 'form-control']) }}
                <p class="error-messaage v_tag_id">
                    @if ($errors->has('tag_id'))
                    <?= $errors->first('tag_id'); ?>
                    @endif
                </p>
            </div>
            <input type="hidden" name="status" value="0">
            <input type="hidden" name="approval_status" value="1">
        </div>
            <div class="corporationBtn">
                <div class="form-actions">
                    <button type="button" class="btn btn-sm btn-dark btn-submit"><img src="{{ asset('images/application.png') }}" alt=""></button>
                </div>
            </div>
        </div>
