<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contenu
 *
 * @property int $id
 * @property string $titre
 * @property string|null $texte
 * @property string $statut
 * @property int|null $parent_id
 * @property int $region_id
 * @property int $langue_id
 * @property int $type_contenu_id
 * @property int|null $id_auteur
 * @property int|null $id_moderateur
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Langue $langue
 * @property Contenu|null $contenu
 * @property Region $region
 * @property TypeContenu $type_contenu
 * @property Collection|Commentaire[] $commentaires
 * @property Collection|Contenu[] $contenus
 * @property Collection|Media[] $media
 *
 * @package App\Models
 */
class Contenu extends Model
{
	protected $table = 'contenus';

	protected $casts = [
		'parent_id' => 'int',
		'region_id' => 'int',
		'langue_id' => 'int',
		'type_contenu_id' => 'int',
		'id_auteur' => 'int',
		'id_moderateur' => 'int'
	];

	protected $fillable = [
		'titre',
		'texte',
		'statut',
		'parent_id',
		'region_id',
		'langue_id',
		'type_contenu_id',
		'id_auteur',
		'id_moderateur'
	];

	public function moderateur()
	{
		return $this->belongsTo(User::class, 'id_moderateur');
	}
    public function auteur()
    {
        return $this->belongsTo(User::class, 'id_auteur');
    }
    public function getStatusClassAttribute()
    {
        return match($this->statut) {
            'actif' => 'bg-success',
            'inactif' => 'bg-danger',
            default => 'bg-secondary',
        };
    }



	public function langue()
	{
		return $this->belongsTo(Langue::class);
	}

	public function contenu()
	{
		return $this->belongsTo(Contenu::class, 'parent_id');
	}

	public function region()
	{
		return $this->belongsTo(Region::class);
	}

	public function type_contenu()
	{
		return $this->belongsTo(TypeContenu::class);
	}

	public function commentaires()
	{
		return $this->hasMany(Commentaire::class, 'id_contenu');
	}

	public function contenus()
	{
		return $this->hasMany(Contenu::class, 'parent_id');
	}

	public function media()
	{
		return $this->hasMany(Media::class, 'id_contenu');
	}
}
