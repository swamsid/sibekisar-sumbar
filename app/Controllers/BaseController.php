<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
    private $scripts = array();
    private $styles = array();
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
        helper("base_helper");
        $this->session = \Config\Services::session();
        $this->cache = \Config\Services::cache();

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
	}

    protected function addScript($filePath)
    {
        if (!empty($filePath) and preg_match("/^http/i", $filePath)) {
            array_push($this->scripts, $filePath);
            return;
        }
        if (is_readable($filePath)) {
            array_push($this->scripts, base_url($filePath));
            return;
        }
    }

    protected function getScripts()
    {
        return $this->scripts;
    }

    protected function addStyle($filePath)
    {
        if (!empty($filePath) and preg_match("/^http/i", $filePath)) {
            array_push($this->styles, $filePath);
            return;
        }
        if (is_readable($filePath)) {
            array_push($this->styles, base_url($filePath));
            return;
        }
    }

    protected function getStyles()
    {
        return $this->styles;
    }

    protected function show($template = '', array &$data = array())
    {
        $data['content'] = $template;
        $this->renderAssets('apps/page', $data);
    }

    private function renderAssets($template = '', &$data)
    {
        $data['scripts'] = $this->scripts;
        $data['styles'] = $this->styles;
        echo view($template, $data);
    }
}
