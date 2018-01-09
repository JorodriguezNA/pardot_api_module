<?php namespace Pardot\PardotapiModule\Http\Controller\Admin;

use Pardot\PardotapiModule\Instance\Form\InstanceFormBuilder;
use Pardot\PardotapiModule\Instance\Table\InstanceTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class InstancesController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param InstanceTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(InstanceTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param InstanceFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(InstanceFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param InstanceFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(InstanceFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
