<?php
namespace App\Models;

class Tag extends BaseModel
{
  // タグテーブル
  protected $table = 'tags';
  protected $fillable =
  [
      'name'
  ];

  public function jobs() {
    return $this->hasMany(Job::class);
}
}
