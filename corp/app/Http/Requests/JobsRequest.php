<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class JobsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'occupation_id' => 'required|not_in:0',
            'business_content' => 'required',
            'employment_form' => 'required|not_in:0',
            'hired_people_no' => 'required|numeric',
            'test_period' => 'required|numeric',
            'contract_period' => 'required|numeric',
            'working_start_time' => 'required|numeric',
            'working_end_time' => 'required|numeric',
            'overtime_hours' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'occupation_id.required' => '職種を選択してください',
            'occupation_id.not_in' => '職種を選択してください',
            'business_content.required' => '仕事内容を入力してください',
            'employment_form.required' => '雇用形態を選択してください',
            'employment_form.not_in' => '雇用形態を選択してください',
            'hired_people_no.required' => '採用予定人数を入力してください',
            'hired_people_no.numeric' => '採用予定人数は数字で入力してください',
            'test_period.required' => '試用期間を入力してください',
            'test_period.numeric' => '試用期間は数字で入力してください',
            'contract_period.required' => '契約期間を入力してください',
            'contract_period.numeric' => '契約期間は数字で入力してください',
            'working_start_time.required' => '始業開始時刻を入力してください',
            'working_start_time.numeric' => '始業開始時刻は数字で入力してください',
            'working_end_time.required' => '終業開始時刻を入力してください',
            'working_end_time.numeric' => '終業開始時刻は数字で入力してください',
            'overtime_hours.required' => '残業時間を入力してください',
            'overtime_hours.numeric' => '残業時間は数字で入力してください',
        ];
    }
  
    public function withValidator(Validator $validator)
    {
    
    }
    protected function failedValidation(Validator $validator)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->merge(['validated' => 'true']);
            throw new HttpResponseException(
                redirect($this->getRedirectUrl())
                ->withErrors($validator)
                ->withInput($this->input())
            );
        }
    }
}
