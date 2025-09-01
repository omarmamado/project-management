<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaRoadmap extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'name', 'description', 'file', 'created_by'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function ideas()
{
    return $this->hasMany(Idea::class);
}
  public function votes() {
        return $this->hasMany(IdeaVote::class, 'idea_id');
    }

}