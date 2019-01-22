<?php

namespace OTHMAN\OsSlider\Controller;

/***************************************************************
 * SliderController
 * 'author' => 'Majd Othman',
 * 'author_email' => 'majd.os.sy@hotmail.com',
 ***************************************************************/

use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Plugin\AbstractPlugin;

/**
 * Class SliderController
 *
 * @package OTHMAN\OsSlider\Controller
 */
class SliderController extends AbstractPlugin
{
    /**
     * @var array
     */
    protected $flexFormValues = [];

    /**
     * @var  ContentObjectRenderer
     */
    public $cObj;

    /**
     * @var StandaloneView
     */
    private $renderer;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        $this->renderer = GeneralUtility::makeInstance(StandaloneView::class);
    }

    /**
     * @param string $content The Plugin content
     * @param array $conf The Plugin configuration
     * @return mixed|string
     * @throws \InvalidArgumentException
     */
    public function main($content, array $conf)
    {
        $this->init();

        return $this->dispatch('getData', $this->cObj, $this->flexFormValues, $conf);
    }

    /**
     * get data from FlexForm and set in this->$flexFormValues[]
     */
    protected function init()
    {
        $this->pi_initPIflexForm();
        $piFlexForm = $this->cObj->data['pi_flexform'];
        foreach ($piFlexForm['data'] as $sheet => $data) {
            foreach ($data as $lang => $value) {
                foreach ($value as $key => $val) {
                    $this->flexFormValues[$key] = $this->pi_getFFvalue($piFlexForm, $key, $sheet);
                }
            }
        }
    }

    /**
     * @param $flexForm
     * @return mixed
     */
    private function flexExplode($flexForm)
    {
        $flexValues['width'] = $flexForm['width'];
        $flexValues['height'] = $flexForm['height'];

        return $flexValues;
    }

    /**
     * @param $action
     * @param $cObj
     * @param $flexValues
     * @param $conf
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function dispatch($action, $cObj, $flexValues, $conf)
    {

        $this->cObj = $cObj;
        $flexValues = $this->flexExplode($flexValues);

        $flexValues['image'] = $this->getFalDataForContent(
            $this->cObj->data['uid'],
            'image',
            'tt_content'
        );

        /** $conf['fileTemplate'] find it in EXT:os_slider/Configuration/TypoScript/Plugins/tx_osslider.ts */
        $this->renderer->setTemplatePathAndFilename($conf['fileTemplate']);
        if (method_exists($this, $action)) {
            $this->renderer->assign('cObj', $this->cObj->data);
            $this->renderer->assign('slider', $flexValues);

            return $this->renderer->render();
        }
    }

    /**
     * @param $id int tt_content uid
     * @param string $key
     * @param string $table
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function getFalDataForContent($id, $key = 'image', $table = 'tt_content')
    {
        $data = [];

        /** @var  $fileRepository FileRepository */
        $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
        $fileObjects = $fileRepository->findByRelation($table, $key, (int)$id);
        if (is_array($fileObjects) || is_object($fileObjects)) {
            $rows = [];
            foreach ($fileObjects as $fileObject) {
                /** @var $fileObject \TYPO3\CMS\Core\Resource\FileReference */
                // oder variante 2: nur bestimmte properties holen
                $rows[] = [
                    'filepath' => $fileObject->getPublicUrl(),
                    'title' => $fileObject->getReferenceProperty('title'),
                    'link' => $fileObject->getReferenceProperty('link'),
                    'description' => $fileObject->getReferenceProperty('description'),
                    'alternative' => $fileObject->getReferenceProperty('alternative'),
                ];
            }
            $data[] = $rows;
        }


        return $data;
    }
}
