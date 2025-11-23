<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commentaire
 * 
 * @property int $id
 * @property string|null $commentaire
 * @property int $note
 * @property int $id_user
 * @property int $id_contenu
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Contenu $contenu
 * @property User $user
 *
 * @package App\Models
 */
class Commentaire extends Model
{
	protected $table = 'commentaires';

	protected $casts = [
		'note' => 'int',
		'id_user' => 'int',
		'id_contenu' => 'int'
	];

	protected $fillable = [
		'commentaire',
		'note',
		'id_user',
		'id_contenu'
	];

	public function contenu()
	{
		return $this->belongsTo(Contenu::class, 'id_contenu');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_user');
	}
}
