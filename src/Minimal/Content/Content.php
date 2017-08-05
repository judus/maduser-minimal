<?php namespace Maduser\Minimal\Content\Content;

use Maduser\Minimal\Config\Contracts\ConfigInterface;


class Content
{
    private $editMode = true;
    private $config;

    private $availableElements = [];

    private $storagePath;
    private $element;

    /**
     * @return array
     */
    public function getAvailableElements(): array
    {
        return $this->availableElements;
    }

    /**
     * @param array $availableElements
     */
    public function setAvailableElements(array $availableElements)
    {
        $this->availableElements = $availableElements;
    }

    /**
     * @return mixed
     */
    public function getStoragePath()
    {
        return $this->storagePath;
    }

    /**
     * @param mixed $storagePath
     */
    public function setStoragePath($storagePath)
    {
        $this->storagePath = $storagePath;
    }

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->setStoragePath(PATH .$this->config->item('content.path'));

        $elements = include(__DIR__ .'/config.php');
        $this->setAvailableElements($elements);
    }

    public function area(array $area)
    {
        $content = $this->getAreaContents($area['name']);

        if ($this->editMode) {
            $topBar = $this->view('area-top-bar', [
                'areaLabel' => $area['label']
            ]);

            $bottomBar = $this->view('area-bottom-bar', [
                'areaName' => $area['name']
            ]);


            $elements = $this->view('elements-list', [
                'areaName' => $area['name'],
                'elements' => $this->getElements($area['accept'])
            ]);

            $modal = $this->view('modal', [
                'elements' => $elements,
                'areaName' => $area['name']
            ]);

            return $this->view('area-wrapper', [
                'content' => $topBar . $content . $bottomBar,
                'modal' => $modal
            ]);
        }

        return $content;
    }

    public function getAreaContents($areaName)
    {
        $page = $this->getPage(md5($_SERVER['REQUEST_URI']));
        $render = '';
        if (isset($page['areas'][$areaName])) {
            foreach ($page['areas'][$areaName] as $element) {
                $render .= $this->renderElement($element);
            }
        }

        return $render;
    }

    protected function renderElement($element)
    {
        $content = $element['content'];

        $element = $this->getElement($element['element']);

        $this->element = $element;

        $view = $this->view($element['view'], $content);

        return $view;
    }

    public function getEditTopBar()
    {
        if ($this->editMode) {
            return $this->view('edit-top-bar', [
                'elementLabel' => $this->element['label']
            ]);
        }

        return null;
    }

    public function getEditBottomBar()
    {
        if ($this->editMode) {
            return $this->view('edit-bottom-bar', [
                'contentElementName' => $this->element['name']
            ]);
        }

        return null;
    }

    /**
     * @param array $elementNames
     *
     * @return mixed
     */
    public function getElements(array $elementNames)
    {
        $elements = [];
        foreach ($elementNames as $name) {
            if ($element = $this->getElement($name)) {
                $elements[] = $element;
            }
        }

        return $elements;
    }

    public function getElement($name)
    {
        if (isset($this->availableElements[$name])) {
            return $this->availableElements[$name];
        }
        return null;
    }

    public function view($viewFileName, array $data = null)
    {
        ($data)? extract($data): null;

        ob_start();
        /** @noinspection PhpIncludeInspection */
        include __DIR__ .'/'.$viewFileName.'.php';
        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }

    public function getFilePath($filename)
    {
        return $this->getStoragePath() .'/'.$filename;
    }

    public function getPage($fileName)
    {
        if (file_exists($this->getFilePath($fileName))) {
            $json = file_get_contents($this->getFilePath($fileName));
            $page = json_decode($json, true);
            return $page;
        }

        return [];
    }

    public function savePage(array $data)
    {
        $json = json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        file_put_contents($this->getFilePath($data['id']), $json);
    }


    public function save(array $data)
    {
        $fileName = md5($data['page']['name']);
        $areaName = $data['area']['name'];
        $contents = [];

        $page = $this->getPage($fileName);

        if (!isset($contents[$areaName])) {
            $contents[$areaName] = [];
        }

        $page['id'] = $fileName;
        $page['name'] = $data['page']['name'];
        $page['areas'][$areaName][] = [
            'element' => $data['element']['name'],
            'content' => $data['content']
        ];

        $this->savePage($page);

        return($page['name']);
    }
}