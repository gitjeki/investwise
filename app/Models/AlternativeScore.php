<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternativeScore extends Model
{
    use HasFactory;
    protected $fillable = ['instrument_id', 'criteria_id', 'score'];

    public function instrument()
    {
        return $this->belongsTo(InvestmentInstrument::class, 'instrument_id');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}