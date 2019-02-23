<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApprovalElement;
use Httpfactory\Approvals\Models\Tag;

class ApprovalProcess extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];


    /**
     * Gets the approval element associated with this approval process.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function approvalElement()
    {
        return $this->hasOne(\Httpfactory\Approvals\Models\ApprovalElement::class);
    }


    /**
     * Gets the tags that belong to this approval process.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'approval_process_tags');
    }


    /**
     * Creates a new Tag
     *
     * @param $theTagName
     * @return Tag
     */
    public function createTag($theTagName)
    {
        $tag = new Tag();
        $tag->name = $theTagName;
        $tag->save();

        return $tag;
    }


    /**
     * Handles checking if the tag exists
     *
     * @param $theTagName
     * @return mixed
     */
    public function tagExists($theTagName)
    {
        $tag = Tag::where('name', '=', $theTagName)->first();
        if(empty($tag)){
            return false;
        }

        return $tag;
    }
}