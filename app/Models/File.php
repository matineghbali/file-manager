<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class File
 *
 * @property-read Folder $folder
 *
 * @property int $id
 * @property int $folder_id
 * @property string $name
 * @property string $type
 * @property int $size
 * @property string $access_token
 * @property string $path
 *
 */
class File extends Model
{
    use HasFactory, SoftDeletes;

    const IMAGE_TYPE = 'image';
    const DOCUMENT_TYPE = 'document';
    const VIDEO_TYPE = 'video';
    const AUDIO_TYPE = 'audio';
    const ALL_TYPES = [
        self::IMAGE_TYPE,
        self::DOCUMENT_TYPE,
        self::VIDEO_TYPE,
        self::AUDIO_TYPE
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'folder_id',
        'name',
        'type',
        'size',
        'access_token',
        'path'
    ];

    /**
     * @return BelongsTo
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
