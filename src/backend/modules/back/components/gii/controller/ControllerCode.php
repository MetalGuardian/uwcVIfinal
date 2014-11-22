<?php

class ControllerCode extends CCodeModel
{
	const BASE_NAMESPACE = 'backend';
	public $controller;
	public $baseClass = '\back\components\BackController';
	public $actions = 'index';
	public $template = 'melon';

	public function getNameSpace($finishSlash = false)
	{
		$namespace = null;
		if($this->getModule() === app())
		{
			$path = explode('/', $this->controller);
			$sub = '';
			for($i = 0, $ilen = count($path) - 1; $i < $ilen; $i++)
			{
				$sub .= '\\' . $path[$i];
			}
			$namespace = self::BASE_NAMESPACE ."\\controllers{$sub}";
		}
		elseif(($m = $this->getModule()))
		{
			$path = explode('/', $this->controller);
			$sub = '';
			for($i = 0, $ilen = count($path) - 1; $i < $ilen; $i++)
			{
				if(!empty($sub))
				{
					$sub .= '\\';
				}
				$sub .= $path[$i];
				if($i == 0)
				{
					$sub .= '\\controllers';
				}
			}
			$namespace = $sub;
		}
		if($finishSlash)
		{
			$namespace .= '\\';
		}
		return $namespace;
	}

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('controller, actions, baseClass', 'filter', 'filter'=>'trim'),
			array('controller, baseClass', 'required'),
			array('controller', 'match', 'pattern'=>'/^\w+[\w+\\/]*$/', 'message'=>'{attribute} should only contain word characters and slashes.'),
			array('actions', 'match', 'pattern'=>'/^\w+[\w\s,]*$/', 'message'=>'{attribute} should only contain word characters, spaces and commas.'),
			array('baseClass', 'match', 'pattern'=>'/^[a-zA-Z_\\\\][\w\\\\]*$/', 'message'=>'{attribute} should only contain word characters.'),
			array('baseClass', 'validateReservedWord', 'skipOnError'=>true),
			array('baseClass, actions', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'baseClass'=>'Base Class',
			'controller'=>'Controller ID',
			'actions'=>'Action IDs',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'controller.php',
			'view.php',
		);
	}

	public function successMessage()
	{
		$link=CHtml::link('try it now', Yii::app()->createUrl($this->controller), array('target'=>'_blank'));
		return "The controller has been generated successfully. You may $link.";
	}

	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;

		$this->files[]=new CCodeFile(
			$this->controllerFile,
			$this->render($templatePath.'/controller.php')
		);

		foreach($this->getActionIDs() as $action)
		{
			$this->files[]=new CCodeFile(
				$this->getViewFile($action),
				$this->render($templatePath.'/view.php', array('action'=>$action))
			);
		}
	}

	public function getActionIDs()
	{
		$actions=preg_split('/[\s,]+/',$this->actions,-1,PREG_SPLIT_NO_EMPTY);
		$actions=array_unique($actions);
		sort($actions);
		return $actions;
	}

	public function getControllerClass()
	{
		if(($pos=strrpos($this->controller,'/'))!==false)
			return ucfirst(substr($this->controller,$pos+1)).'Controller';
		else
			return ucfirst($this->controller).'Controller';
	}

	public function getModule()
	{
		if(($pos=strpos($this->controller,'/'))!==false)
		{
			$id=substr($this->controller,0,$pos);
			if(($module=Yii::app()->getModule($id))!==null)
				return $module;
		}
		return Yii::app();
	}

	public function getControllerID()
	{
		if($this->getModule()!==Yii::app())
			$id=substr($this->controller,strpos($this->controller,'/')+1);
		else
			$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getUniqueControllerID()
	{
		$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getControllerFile()
	{
		$module=$this->getModule();
		$id=$this->getControllerID();
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtoupper($id[$pos+1]);
		else
			$id[0]=strtoupper($id[0]);
		return $module->getControllerPath().'/'.$id.'Controller.php';
	}

	public function getViewFile($action)
	{
		$module=$this->getModule();
		return $module->getViewPath().'/'.$this->getControllerID().'/'.$action.'.php';
	}

	public function getBaseClassNamespace()
	{
		return trim($this->baseClass, '\\');
	}

	public function getBaseClassWithoutNamespace()
	{
		$array = $array = explode('\\', $this->baseClass);
		return end($array);
	}
}