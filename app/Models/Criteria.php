<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name', 'type', 'question'];

    public function subCriterias()
    {
        return $this->hasMany(SubCriteria::class);
    }

    public function alternativeScores()
    {
        return $this->hasMany(AlternativeScore::class);
    }
}