<?php

namespace CodeProject\Validators;
use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class ProjectFileValidator extends LaravelValidator
{

  protected $rules = [
    ValidatorInterface::RULE_CREATE => [
      'name' => 'required',
      'description' => 'required',
      'file' => 'required|mimes:doc,xls,docx,xlsx,odt,ods,ppt,pptx,odp,pdf,jpg,jpeg,png,bmp,gif',
    ],
    ValidatorInterface::RULE_UPDATE => [
      'name' => 'required',
      'description' => 'required',
    ]
  ];

}
