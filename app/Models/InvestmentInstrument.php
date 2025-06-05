<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentInstrument extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type'];

    public function alternativeScores()
    {
        return $this->hasMany(AlternativeScore::class, 'instrument_id');
    }
}