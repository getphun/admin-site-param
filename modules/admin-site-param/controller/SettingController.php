<?php
/**
 * Admin site params management
 * @package admin-site-param
 * @version 0.0.1
 * @upgrade true
 */

namespace AdminSiteParam\Controller;
use SiteParam\Model\SiteParam as SParam;

class SettingController extends \AdminController
{

    private function _defaultParams(){
        return [
            'title'             => 'Site Params',
            'nav_title'         => 'Setting',
            'active_menu'       => 'setting',
            'active_submenu'    => 'params',
            'pagination'        => []
        ];
    }
    
    public function indexAction(){
        if(!$this->user->login)
            return $this->loginFirst('adminLogin');
        if(!$this->can_i->read_setting)
            return $this->show404();
        
        $params = $this->_defaultParams();
        $params['params'] = [];
        $params['groups'] = [];
        $params['jses']   = [ '/js/site-param.js' ];
        
        $objects = SParam::get([], true, false, '`group` ASC, `name` ASC');
        if($objects){
            $params['params'] = $objects;
        
            $groups = array_column($params['params'], 'group');
            $params['groups'] = array_unique($groups);
        }
        
        $this->form->setForm('admin-setting-params-create');
        
        return $this->respond('setting/params/index', $params);
    }
    
    public function editAction(){
        if(!$this->user->login)
            return $this->loginFirst('adminLogin');
        
        $id = $this->param->id;
        
        if(!$id && !$this->can_i->create_setting)
            return $this->show404();
        elseif($id && !$this->can_i->update_setting)
            return $this->show404();
        
        $params = $this->_defaultParams();
        
        $params['title'] = 'Create New Site Params';
        $params['groups']= null;
        $params['next']  = $this->router->to('adminSettingParams');
        
        if($id){
            $params['title'] = 'Edit Site Params';
            $object = SParam::get($id, false);
            if(!$object)
                return $this->show404();
        }else{
            $object = new \stdClass();
            $object->name = $this->req->getQuery('name');
            $object->type = $this->req->getQuery('type') ?? 4;
        }
        
        if(!isset($object->type))
            $object->type = 1;
        
        // get all groups
        $groups = SParam::countGroup('group');
        if($groups){
            $groups = array_keys($groups);
            $params['groups'] = $groups;
        }
        
        $f_value =&\Phun::$config['form']['admin-setting-params-edit']['value'];
        switch($object->type){
            case 1:
                $f_value['type'] = 'text';
                break;
            case 2:
                $f_value['type'] = 'datetime';
                break;
            case 3:
                $f_value['type'] = 'number';
                break;
            case 4:
                $f_value['type'] = 'checkbox';
                $f_value['label'] = 'True/Yes/Enable';
                break;
            case 5:
                $f_value['type'] = 'textarea';
                break;
            case 6:
                $f_value['type'] = 'url';
                break;
            case 7:
                $f_value['type'] = 'email';
                break;
            case 8:
                $f_value['type'] = 'color';
                break;
        }
        
        if(false === ($form = $this->form->validate('admin-setting-params-edit', $object)))
            return $this->respond('setting/params/edit', $params);
        
        if($object->type == 4 && !isset($form->value))
            $form->value = 0;
        
        $object = object_replace($object, $form);
        
        if($id)
            SParam::set($object, $id);
        else
            SParam::create($object);
        
        $this->cache->remove('setting');
        
        $this->redirect($params['next']);
    }
    
    public function removeAction(){
        if(!$this->user->login)
            return $this->show404();
        if(!$this->can_i->remove_setting)
            return $this->show404();
        
        $id = $this->param->id;
        $object = SParam::get($id, false);
        if(!$object)
            return $this->show404();
        
        $this->cache->remove('setting');
        SParam::remove($id);
        $this->redirectUrl('adminSettingParams');
    }
}