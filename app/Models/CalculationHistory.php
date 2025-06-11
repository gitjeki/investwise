<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationHistory extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'user_preferences', 'calculated_rankings'];
    protected $casts = [
        'user_preferences' => 'array',
        'calculated_rankings' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}