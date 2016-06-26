<?php

namespace CodeProject\Validators;
use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{

  protected $rules = [

    'name' => 'required',
    'file' => 'mimes:doc,xls,docx,xlsx,odt,ods,ppt,pptx,odp,pdf,jpg,jpeg,png,bmp,gif',

  ];

}
