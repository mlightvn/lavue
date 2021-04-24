<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseTrait;

class BaseModel extends Model
{
    use HasFactory;
    use BaseTrait;

    public function getDescriptionShortLabel($length = 240){
        $result = $this->description;
        $result = str_replace("\n", "", $result);
        $result = strip_tags($result, "<br>");
        $result = str_replace("<br>", "\n", $result);

        if(strlen($result) > $length){
            $result = substr($result, 0, $length) . '...';
        }
        $result = str_replace("\n", "<br>", $result);

        return $result;

    }

    public function getDescriptionShortLabelAttribute(){
        return $this->getDescriptionShortLabel();
    }

    public function getDescriptionShort480LabelAttribute()
    {
        return $this->getDescriptionShortLabel(480);
    }

    public function getCreatedAtLabelAttribute()
    {
        $createdAtLabel = date("Y/m/d", strtotime($this->created_at));
        return $createdAtLabel;
    }

}
