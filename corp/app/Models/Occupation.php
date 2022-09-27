<?php
namespace App\Models;

class Occupation extends BaseModel
{
  // 職種テーブル
  protected $table = 'occupations';
  protected $fillable =
  [
      'name'
  ];

  public function jobs() {
    return $this->hasMany(Job::class);
}

}
