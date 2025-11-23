<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $sexe
 * @property Carbon $date_naissance
 * @property string $statut
 * @property string|null $photo
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id_role
 * @property int $id_langue
 *
 * @property Langue $langue
 * @property Role $role
 * @property Collection|Commentaire[] $commentaires
 * @property Collection|Contenu[] $contenus
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'date_naissance' => 'date',
		'email_verified_at' => 'datetime',
		'id_role' => 'int',
		'id_langue' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'sexe',
		'date_naissance',
		'statut',
		'photo',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'id_role',
		'id_langue'
	];



	public function langue()
	{
		return $this->belongsTo(Langue::class, 'id_langue');
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'id_role');
	}

	public function commentaires()
	{
		return $this->hasMany(Commentaire::class, 'id_user');
	}

	public function contenus()
	{
		return $this->hasMany(Contenu::class, 'id_moderateur');
	}
}
