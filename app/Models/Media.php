<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Media
 *
 * @property int $id
 * @property string $chemin
 * @property string $description
 * @property int $id_contenu
 * @property int $id_type_media
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Contenu $contenu
 * @property TypeMedia $type_media
 *
 * @package App\Models
 */
class Media extends Model
{
	protected $table = 'medias';

	protected $casts = [
		'id_contenu' => 'int',
		'id_type_media' => 'int'
	];

	protected $fillable = [
		'chemin',
		'description',
		'id_contenu',
		'id_type_media'
	];

	public function contenu()
	{
		return $this->belongsTo(Contenu::class, 'id_contenu');
	}

	public function type_media()
	{
		return $this->belongsTo(TypeMedia::class, 'id_type_media');
	}

    /**
     * Déterminer si le média est une vidéo
     */
    public function isVideo()
    {
        return in_array($this->type_media->nom ??  '', ['Vidéo', 'Video', 'video']);
    }

    /**
     * Déterminer si le média est un audio
     */
    public function isAudio()
    {
        return in_array($this->type_media->nom ?? '', ['AUDIO', 'audio', 'Son']);
    }

    /**
     * Déterminer si le média est une image
     */
    public function isImage()
    {
        return in_array($this->type_media->nom ?? '', ['IMAGE', 'image', 'Photo', 'photo']);
    }

    /**
     * Obtenir l'extension du fichier
     */
    public function getExtension()
    {
        return pathinfo($this->chemin, PATHINFO_EXTENSION);
    }
}
