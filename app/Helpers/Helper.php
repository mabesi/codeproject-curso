<?php
use CodeProject\Entities\User;

function userId()
{
  return \Authorizer::getResourceOwnerId();
}

function currentUser()
{
  $user = User::find(userId());
  return $user;
}

function currentUserName()
{
  return currentUser()->name;
}

function currentUserEmail()
{
  return currentUser()->email;
}

function msgJson($msg,$error)
{
  return response()->json([
    'error' => $error,
    'message' => $msg
  ]);
}

function successJson($msg)
{
  return msgJson($msg,false);
}

function errorJson($msg)
{
  return msgJson($msg,true);
}

function msgError()
{
  return errorJson('Ocorreu um erro ao executar a operação!');
}

function msgResourceNotFound()
{
  return errorJson('Nenhum registro encontrado!');
}

function msgAccessDenied()
{
  return errorJson('Acesso negado!');
}

function msgDeleted()
{
  return successJson('O(s) registro(s) foi(ram) deletado(s) com sucesso!');
}

function msgNotDeleted()
{
  return errorJson('Ocorreu um erro ao deletar o(s) registro(s)!');
}

function msgException($e,$showOriginalMessage = false)
{
  if($e instanceof Illuminate\Database\QueryException){
    if($showOriginalMessage){
      return errorJson($e->getMessage());
    }else{
      return errorJson('Exceção: Erro ao executar a consulta no banco de dados!');
    }
  }elseif($e instanceof Illuminate\Database\Eloquent\ModelNotFoundException){
    if($showOriginalMessage){
      return errorJson($e->getMessage());
    }else{
      return errorJson('Exceção: Objeto não encontrado!');
    }
  }elseif($e instanceof Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
    if($showOriginalMessage){
      return errorJson($e->getMessage());
    }else{
      return errorJson('Exceção: Recurso HTTP não encontrado!');
    }
  }elseif($e instanceof Symfony\Component\Translation\Exception\NotFoundResourceException){
    if($showOriginalMessage){
      return errorJson($e->getMessage());
    }else{
      return errorJson('Exceção: Arquivo de tradução não encontrado!');
    }
  }elseif($e instanceof Prettus\Validator\Exceptions\ValidatorException){
    if($showOriginalMessage){
      return errorJson($e->getMessageBag());
    }else{
      return errorJson('Exceção: Erro ao tentar validar os dados!');
    }
  //}elseif($e instanceof NoActiveAccessTokenException){
  //  if($showOriginalMessage){
  //    return errorJson($e->getMessageBag());
  //  }else{
  //    return errorJson('Exceção: Erro de autenticação/Usuário não logado!');
  //  }
  } else {
    if($showOriginalMessage){
      return errorJson($e->getMessage());
    }else{
      return errorJson('Erro ao executar a operação!');
    }
  }
}
