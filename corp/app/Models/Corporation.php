<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // 認証テーブル変更用記述

//class Corporation extends BaseModel   //変更前
class Corporation extends Authenticatable  // 認証テーブル変更用記述
{
  use HasFactory;

  // 日付フォーマット
  protected $dates = ['establishment_date'];
  // 企業テーブル
  protected $table = 'corporations';
  protected $fillable =
  [
      'name',
      'email',
      'password',
      'tel',
      'mobile_tel',
      'image_path',
      'hp_url',
      'business_location',
      'representative',
      'establishment_date',
      'capital',
      'amount_sales',
      'employees_number',
      'business_content',
      'main_customer',
      'department_name',
      'manager_name',
      'industry_id',
      'status',
  ];

  public function samples() {
      return $this->hasMany(Sample::class);
  }

  public function jobs() {
    return $this->hasMany(Job::class);
  }
}
