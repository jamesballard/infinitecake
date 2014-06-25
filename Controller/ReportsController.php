<?php
App::uses('AppController', 'Controller');
/**
 * Reports Controller
 *
 * @property Report $Report
 */
class ReportsController extends AppController {

    var $uses = array('Report', 'Filter', 'ReportDimension', 'DimensionDate', 'Period', 'Dashboard', 'System');
    var $components = array('RequestHandler');
    public $helpers = array('dynamicForms.dynamicForms');

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'configManage';
        $this->set('visualisation_types', $this->Report->visualisation_types);
        $this->set('filter_operators', $this->Filter->filter_operators);
        $this->set('filter_comparisons', $this->Filter->filter_comparisons);
        $this->set('dimension_models', $this->ReportDimension->dimension_models);
        $this->set('systems', $this->get_customerSystems());
        if (in_array($this->action, array('add', 'edit'))) {
            $customers = $this->getCustomersList();
            $currentUser = $this->get_currentUser();
            $customer_id = array($this->get_allCustomersID(), $currentUser['Member']['customer_id']);
            $dashboards = $this->Dashboard->getCustomerDashboard($customer_id);
            $models = App::objects('model');
            $filterModels = array();
            foreach ($models as $model) {
                $this->loadModel($model);
                $class = new $model;
                if (method_exists($class, 'getFilterOptions')) {
                    $filterModels[$model] = $model;
                }
            }
            $filter_options = array();
            foreach ($filterModels as $key => $value) {
                $this->loadModel($key);
                $class = new $key;
                $filter_options = $class->getFilterOptions($customer_id);
                break;
            }
            $this->set('filter_models', $filterModels);
            $this->set(compact('customers', 'dashboards', 'filter_options'));
        }
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Report->recursive = 0;
		$this->set('reports', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Report->exists($id)) {
			throw new NotFoundException(__('Invalid report'));
		}
		$options = array('conditions' => array('Report.' . $this->Report->primaryKey => $id));
		$this->set('report', $this->Report->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Report->create();
            $dt = DateTime::createFromFormat('d/m/Y', $this->request->data['Report']['startdate']);
            if ($dt) { $this->request->data['Report']['startdate'] = $dt->format('U'); }
            $dt = DateTime::createFromFormat('d/m/Y', $this->request->data['Report']['enddate']);
            if ($dt) { $this->request->data['Report']['enddate'] = $dt->format('U'); }
			if ($this->Report->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The report has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The report could not be saved. Please, try again.'));
			}
		}
        $currentUser = $this->get_currentUser();
        $customer_id = array($this->get_allCustomersID(), $currentUser['Member']['customer_id']);
        $axis_parameters = $this->DimensionDate->getDimensionParameters($customer_id);
        $label_parameters = $this->Period->getDimensionParameters($customer_id);
        $this->set(compact('axis_parameters', 'label_parameters'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Report->exists($id)) {
			throw new NotFoundException(__('Invalid report'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
            $dt = DateTime::createFromFormat('d/m/Y', $this->request->data['Report']['startdate']);
            if ($dt) { $this->request->data['Report']['startdate'] = $dt->format('U'); }
            $dt = DateTime::createFromFormat('d/m/Y', $this->request->data['Report']['enddate']);
            if ($dt) { $this->request->data['Report']['enddate'] = $dt->format('U'); }
            // Delete all filters and re-add.
            $this->Filter->deleteAll(array('report_id' => $id), false);
			if ($this->Report->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The report has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The report could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Report->find('first', array(
                'contain' => array(
                    'Filter' => array(
                        'fields' => array()
                    ),
                    'ReportDimension' => array(),
                    'ReportValue' => array(),
                    'Dashboard' => array()
                ),
                'conditions' => array('Report.'.$this->Report->primaryKey => $id)
            ));
		}
        $customer_id = $this->request->data['Report']['customer_id'];
        $dt = DateTime::createFromFormat('U', $this->request->data['Report']['startdate']);
        if ($dt) { $this->request->data['Report']['startdate'] = $dt->format('d/m/Y'); }
        $dt = DateTime::createFromFormat('U', $this->request->data['Report']['enddate']);
        if ($dt) { $this->request->data['Report']['enddate'] = $dt->format('d/m/Y'); }
        $this->check_customerID($customer_id);

        foreach ($this->request->data['ReportDimension'] as $dimension) {
            $model = $dimension['model'];
            if ($model) {
                $this->loadModel($model);
                $class = new $model;
            }
            if ($dimension['type'] == 1) {
                if ($model) {
                    $axis_parameters = $class->getDimensionParameters($customer_id);
                } else {
                    $axis_parameters = array('' => __('No option required'));
                }
            } else if ($dimension['type'] == 2) {
                if ($model) {
                    $label_parameters = $class->getDimensionParameters($customer_id);
                } else {
                    $label_parameters = array('' => __('No option required'));
                }
            }
        }
        $this->set(compact('axis_parameters', 'label_parameters'));
	}

    public function filter_options_ajax() {
        //$this->request->onlyAllow('ajax');
        $model = $this->request->query('model');
        if (!$model) {
            throw new NotFoundException();
        }

        $this->layout = 'ajax';
        $this->viewClass = 'Tools.Ajax';

        $this->loadModel($model);
        $class = new $model;
        $cacheName = $model.'list';
        $filter_options = Cache::read($cacheName, 'short');
        if (!$filter_options) {
            $filter_options = $class->find('list');
            Cache::write($cacheName, $filter_options, 'short');
        }
        $this->set(compact('filter_options'));
    }

    public function axis_options_ajax() {
        //$this->request->onlyAllow('ajax');
        $model = $this->request->query('id');
        $this->layout = 'ajax';
        $this->viewClass = 'Tools.Ajax';

        if (!$model) {
            $options = array();
        } else {
            $customer_id = array(
                $this->get_allCustomersID(),
                $this->get_currentUser()['Member']['customer_id'],
            );

            $this->loadModel($model);
            $class = new $model;
            $cacheName = $model.'dimension.parameters';
            $options = Cache::read($cacheName, 'short');
            if (!$options) {
                $options = $class->getDimensionParameters($customer_id);
                Cache::write($cacheName, $options, 'short');
            }
        }
        $this->set(compact('options'));
    }

    public function label_options_ajax() {
        //$this->request->onlyAllow('ajax');
        $model = $this->request->query('id');
        $this->layout = 'ajax';
        $this->viewClass = 'Tools.Ajax';

        if (!$model) {
            $options = array();
        } else {
            $customer_id = array(
                $this->get_allCustomersID(),
                $this->get_currentUser()['Member']['customer_id'],
            );

            $this->loadModel($model);
            $class = new $model;
            $cacheName = $model.'dimension.parameters';
            $options = Cache::read($cacheName, 'short');
            if (!$options) {
                $options = $class->getDimensionParameters($customer_id);
                Cache::write($cacheName, $options, 'short');
            }
        }
        $this->set(compact('options'));
    }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Report->id = $id;
		if (!$this->Report->exists()) {
			throw new NotFoundException(__('Invalid report'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Report->delete()) {
			$this->Session->setFlash(__('Report deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Report was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
