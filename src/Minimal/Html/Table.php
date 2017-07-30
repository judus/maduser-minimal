<?php

namespace Maduser\Minimal\Html;

/**
 * Class Table
 *
 * @package Maduser\Minimal\Html
 */
class Table
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $theadData = [];

    /**
     * @var array
     */
    protected $tfootData = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $defaults = [];

    /**
     * @var string
     */
    protected $tableId = '';

    /**
     * @var string
     */
    protected $tableClass = '';

    /**
     * @var string
     */
    protected $caption = '';

    /**
     * @var bool
     */
    protected $thead = false;

    /**
     * @var
     */
    protected $tfoot;

    protected $showColgroup = false;

    protected $showThead = false;

    protected $showTfoot = false;

    protected $showRowIndex = false;

    protected $showRowCheckbox = false;

    protected $primaryKey = '0';

    protected $checkboxName = 'ids[]';

    protected $showColSearch = false;

    protected $theadUsesValue = false;
    protected $tfootUsesValue = false;

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return Table
     */
    public function setData(array $data = null): Table
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getTheadData(): array
    {
        $theadData = isset($this->options['thead']['value']) ?
            $this->options['thead']['value'] : [];
        $theadData = is_callable($theadData) ? $theadData($this->getData()) : $theadData;

        return $theadData;
    }

    /**
     * @param array $theadData
     *
     * @return Table
     */
    public function setTheadData(array $theadData): Table
    {
        if ($theadData) {
            $this->options['thead']['value'] = $theadData;
        } else {
            $this->options['thead'] = null;
        }

        $this->theadData = $theadData;

        return $this;
    }

    /**
     * @return array
     */
    public function getTfootData(): array
    {
        $tfootData = isset($this->options['tfoot']['value']) ?
            $this->options['tfoot']['value'] : [];
        $tfootData = is_callable($tfootData) ? $tfootData($this->getData()) : $tfootData;

        return $tfootData;
    }

    /**
     * @param array $tfootData
     *
     * @return Table
     */
    public function setTfootData(array $tfootData): Table
    {
        if ($tfootData) {
            $this->options['tfoot']['value'] = $tfootData;
        } else {
            $this->options['tfoot'] = null;
        }

        $this->tfootData = $tfootData;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array|null $options
     *
     * @return Table
     */
    public function setOptions(array $options = null): Table
    {
        $this->options = $options ? $options : [];

        return $this;
    }

    /**
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @return Table
     */
    public function setDefaults(): Table
    {
        $this->defaults = [
            'table' => [
                'tag' => "<table%s>%s\n</table>",
            ],
            'checkbox' => [
                'tag' => "<input type=\"checkbox\" name=\"%s\" value=\"%s\">",
            ],
            'caption' => [
                'tag' => "\n\t<caption%s>%s</caption>",
            ],
            'colgroup' => [
                'tag' => "\n\t<colgroup%s>%s\n\t</colgroup>",
            ],
            'col' => [
                'tag' => "\n\t\t<col%s>",
            ],
            'thead' => [
                'tag' => "\n\t<thead%s>%s\n\t</thead>",
            ],
            'thead_tr' => [
                'tag' => "\n\t\t<tr%s>%s\n\t\t</tr>",
            ],
            'tbody' => [
                'tag' => "\n\t<tbody%s>%s\n\t</tbody>",
            ],
            'tfoot' => [
                'tag' => "\n\t<tfoot%s>%s\n\t</tfoot>",
            ],
            'tfoot_tr' => [
                'tag' => "\n\t\t<tr%s>%s\n\t\t</tr>",
            ],
            'tfoot_td' => [
                'tag' => "\n\t\t\t<td%s>%s</td>",
            ],
            'tr' => [
                'tag' => "\n\t\t<tr%s>%s\n\t\t</tr>",
            ],
            'th' => [
                'tag' => "\n\t\t\t<th%s>%s</th>",
            ],
            'td' => [
                'tag' => "\n\t\t\t<td%s>%s</td>",
            ],
        ];

        return $this;
    }

    /**
     * @return string
     */
    public function getTableId(): string
    {
        return $this->tableId;
    }

    /**
     * @param mixed $tableId
     *
     * @return Table
     */
    public function setTableId($tableId): Table
    {
        $this->tableId = $tableId;
        $this->options['table']['id'] = $tableId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTableClass(): string
    {
        return $this->tableClass;
    }

    /**
     * @param mixed $tableClass
     *
     * @return Table
     */
    public function setTableClass($tableClass): Table
    {
        $this->tableClass = $tableClass;
        $this->options['table']['class'] = $tableClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @param mixed $caption
     *
     * @return Table
     */
    public function setCaption($caption): Table
    {
        $this->caption = $caption;
        $this->options['caption']['value'] = $caption;

        return $this;
    }

    /**
     * @return bool
     */
    public function isThead(): bool
    {
        return $this->thead;
    }

    /**
     * @param array|null $thead
     *
     * @param bool       $useKeyName
     *
     * @return Table
     */
    public function setThead(array $thead = null, $useKeyName = false): Table
    {
        $this->setTheadUsesValue(!$useKeyName);
        $this->setShowThead(true);

        !is_array($thead) || $this->setTheadData($thead);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTfoot()
    {
        return $this->tfoot;
    }

    /**
     * @param array|null $tfoot
     *
     * @param bool       $useKeyName
     *
     * @return Table
     */
    public function setTfoot(array $tfoot = null, $useKeyName = false)
    {
        $this->setTfootUsesValue(!$useKeyName);
        $this->setShowTfoot(!is_null($tfoot));
        $this->setTfootData($tfoot);

        return $this;
    }

    /**
     * @return bool
     */
    public function isShowColgroup(): bool
    {
        return $this->showColgroup;
    }

    /**
     * @param bool $showColgroup
     *
     * @return Table
     */
    public function setShowColgroup(bool $showColgroup): Table
    {
        $this->showColgroup = $showColgroup;

        return $this;
    }

    /**
     * @return bool
     */
    public function isShowThead(): bool
    {
        return $this->showThead;
    }

    /**
     * @param bool $showThead
     *
     * @return Table
     */
    public function setShowThead(bool $showThead): Table
    {
        $this->showThead = $showThead;

        return $this;
    }

    /**
     * @return bool
     */
    public function isShowTfoot(): bool
    {
        return $this->showTfoot;
    }

    /**
     * @param bool $showTfoot
     *
     * @return Table
     */
    public function setShowTfoot(bool $showTfoot): Table
    {
        $this->showTfoot = $showTfoot;

        return $this;
    }

    public function showRowIndex($show = true)
    {
        $this->showRowIndex = $show;

        return $this;
    }

    public function isShowRowIndex()
    {
        return $this->showRowIndex;
    }

    public function showRowCheckbox($show = true)
    {
        if (is_bool($show)) {
            $data = $this->getData();
            $firstRow = array_slice($data, 0, 1);
            $key = key($firstRow);
            $firstCol = array_slice($firstRow[$key], 0, 1);
            $primary = key($firstCol);
        } else {
            $primary = $show;
        }

        $this->setPrimaryKey($primary);
        $this->setCheckboxName($primary . '[]');
        $this->showRowCheckbox = ($show !== false);

        return $this;
    }

    public function isShowRowCheckbox()
    {
        return $this->showRowCheckbox;
    }

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * @param string $primaryKey
     *
     * @return Table
     */
    public function setPrimaryKey(string $primaryKey): Table
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getCheckboxName(): string
    {
        return $this->checkboxName;
    }

    /**
     * @param string $checkboxName
     *
     * @return Table
     */
    public function setCheckboxName(string $checkboxName): Table
    {
        $this->checkboxName = $checkboxName;

        return $this;
    }

    /**
     * @return bool
     */
    public function isShowColSearch(): bool
    {
        return $this->showColSearch;
    }

    /**
     * @param bool $showColSearch
     *
     * @return Table
     */
    public function showColSearch(bool $showColSearch = true): Table
    {
        $this->showColSearch = $showColSearch;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTheadUsesValue(): bool
    {
        return $this->theadUsesValue;
    }

    /**
     * @param bool $theadUsesValue
     *
     * @return Table
     */
    public function setTheadUsesValue(bool $theadUsesValue): Table
    {
        $this->theadUsesValue = $theadUsesValue;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTfootUsesValue(): bool
    {
        return $this->tfootUsesValue;
    }

    /**
     * @param bool $tfootUsesValue
     *
     * @return Table
     */
    public function setTfootUsesValue(bool $tfootUsesValue): Table
    {
        $this->tfootUsesValue = $tfootUsesValue;

        return $this;
    }


    /**
     * Table constructor.
     *
     * @param array|null      $data
     * @param array $options
     */
    public function __construct(array $data = null, $options = [])
    {
        $this->setDefaults();
        $this->setData($data);
        $this->setOptions($options);
    }

    public function setIds()
    {
        if (!isset($this->options['table']['id'])) {
            $this->options['table']['id'] = function () {
                return uniqid('table_');
            };
        }

        $tableId = is_callable($this->options['table']['id']) ?
            $this->options['table']['id']($this->getOptions()) : $this->options['table']['id'];

        if (!isset($this->options['thead_tr']['id'])) {
            $this->options['thead_tr']['id'] = function (
                $rowIndex
            ) use ($tableId) {
                return $tableId . '_thead_tr_' . $rowIndex;
            };
        }

        if (!isset($this->options['tfoot_tr']['id'])) {
            $this->options['tfoot_tr']['id'] = function (
                $rowIndex
            ) use ($tableId) {
                return $tableId . '_tfoot_tr_' . $rowIndex;
            };
        }

        if (!isset($this->options['th']['id'])) {
            $this->options['th']['id'] = function (
                $rowIndex,
                $colIndex
            ) use ($tableId) {
                return $tableId . '_th_' . $rowIndex . '_' . $colIndex;
            };
        }

        if (!isset($this->options['tr']['id'])) {
            $this->options['tr']['id'] = function (
                $rowIndex
            ) use ($tableId) {
                return $tableId . '_tr_' . $rowIndex;
            };
        }

        if (!isset($this->options['td']['id'])) {
            $this->options['td']['id'] = function (
                $rowIndex,
                $colIndex
            ) use ($tableId) {
                return $tableId . '_td_' . $rowIndex . '_' . $colIndex;
            };
        }

        if (!isset($this->options['tfoot_td']['id'])) {
            $this->options['tfoot_td']['id'] = function (
                $rowIndex,
                $colIndex
            ) use ($tableId) {
                return $tableId . '_tfoot_td_' . $rowIndex . '_' . $colIndex;
            };
        }
    }

    public function setClasses()
    {
        if (!isset($this->options['table']['class'])) {
            $this->options['table']['class'] = function () {
                return 'table';
            };
        }

        if (!isset($this->options['thead_tr']['class'])) {
            $this->options['thead_tr']['class'] = function (
                $rowIndex
            ) {
                return 'thead_tr thead_tr_' . $rowIndex;
            };
        }

        if (!isset($this->options['tfoot_tr']['class'])) {
            $this->options['tfoot_tr']['class'] = function (
                $rowIndex
            ) {
                return 'tfoot_tr tfoot_tr_' . $rowIndex;
            };
        }

        if (!isset($this->options['th']['class'])) {
            $this->options['th']['class'] = function (
                $rowIndex,
                $colIndex
            ) {
                return 'th th_' . $rowIndex . '_' . $colIndex;
            };
        }

        if (!isset($this->options['tr']['class'])) {
            $this->options['tr']['class'] = function (
                $rowIndex
            ) {
                return 'tr tr_' . $rowIndex;
            };
        }

        if (!isset($this->options['td']['class'])) {
            $this->options['td']['class'] = function (
                $rowIndex,
                $colIndex
            ) {
                return 'td td_' . $rowIndex . '_' . $colIndex;
            };
        }

        if (!isset($this->options['tfoot_td']['class'])) {
            $this->options['tfoot_td']['class'] = function (
                $rowIndex,
                $colIndex
            ) {
                return 'tfoot_td tfoot_td_' . $rowIndex . '_' . $colIndex;
            };
        }
    }

    public function setAttributes()
    {
        $this->setIds();
        $this->setClasses();
    }

    /**
     * @param array|null $data
     * @param array|null $options
     *
     * @return string
     */
    public function make(array $data = null, array $options = null)
    {
        $data = $data ? $data : $this->getData();
        $this->setData($data);

        $options = $options ? $options : $this->getOptions();
        $options = array_replace_recursive($this->getDefaults(), $options);
        $this->setOptions($options);




        if ($this->isShowRowCheckbox()) {
            $this->addRowCheckbox();
        }

        if ($this->isShowRowIndex()) {
            $this->addRowIndex();
        }

        if ($this->isShowColSearch()) {
            $this->addColSearch();
        }

        $options = $this->getOptions();
        $data = $this->getData();

        $attributes = [];

        // Attributes for wrappers
        $attributes['table'] = $this->getAttributes('table', $options);
        $attributes['caption'] = $this->getAttributes('caption', $options);
        $attributes['colgroup'] = $this->getAttributes('colgroup', $options);
        $attributes['thead'] = $this->getAttributes('thead', $options);
        $attributes['tbody'] = $this->getAttributes('tbody', $options);
        $attributes['tfoot'] = $this->getAttributes('tfoot', $options);

        // caption
        $caption = isset($options['caption']['value']) ?
            $options['caption']['value'] : '';

        // colgroup data
        $cols = '';
            if (is_array($options['colgroup']) && $this->isShowColgroup()) {
            $colsData = isset($options['colgroup']['value']) ?
                $options['colgroup']['value'] : array_slice($data, 0, 1);
            $cols = $this->getColgroup($colsData, $options);
        }

        // thead data
        $thead_rows = '';
        if (is_array($options['thead']) && $this->isShowThead()) {
            $theadData = isset($options['thead']['value']) ?
                $options['thead']['value'] : array_slice($data, 0, 1);
            $theadData = is_callable($theadData) ? $theadData($data) : $theadData;
            $thead_rows = $this->getGrid($theadData, 'thead_tr', 'th',
                $options);
        }

        // tfoot data
        $tfoot_rows = '';
        if (is_array($options['tfoot']) && $this->isShowTfoot()) {
            $tfootData = isset($options['tfoot']['value']) ?
                $options['tfoot']['value'] : null;
            $tfootData = is_callable($tfootData) ? $tfootData($data) : $tfootData;
            $tfoot_rows = $this->getGrid($tfootData, 'tfoot_tr', 'tfoot_td',
                $options);
        }

        // tbody data
        $tbody_rows = $this->getGrid($data, 'tr', 'td', $options);

        // Render wrappers
        $caption = empty($caption) ?
            '' : sprintf($options['caption']['tag'], $attributes['caption'],
                $caption);

        $colgroup = empty($cols) ?
            '' : sprintf($options['colgroup']['tag'], $attributes['colgroup'],
                $cols);

        $thead = empty($thead_rows) ?
            '' : sprintf($options['thead']['tag'], $attributes['thead'],
                $thead_rows);

        $tbody = sprintf($options['tbody']['tag'], $attributes['tbody'],
            $tbody_rows);

        $tfoot = empty($tfoot_rows) ?
            '' : sprintf($options['tfoot']['tag'], $attributes['tfoot'],
                $tfoot_rows);

        $table = $caption .$colgroup . $thead . $tbody . $tfoot;

        return sprintf($options['table']['tag'], $attributes['table'], $table);
    }


    /**
     * @param      $name
     * @param null $options
     *
     * @return string
     */
    public function getAttributes($name, $options = null)
    {
        $attributes = '';

        if (!is_array($options[$name])) {
            return $attributes;
        }

        foreach ($options[$name] as $key => $value) {
            if ($key !== 'tag' && $key !== 'value') {
                $value = is_callable($value) ? $value($options[$name], $options) : $value;
                $attributes .= !empty($value) ? ' ' . $key . '="' . $value . '"' : '';
            }
        }

        return $attributes;
    }

    /**
     * @param      $data
     * @param null $options
     *
     * @return string
     */
    public function getColgroup($data, $options = null)
    {
        $cols = '';
        $i = 0;
        foreach ($data as $rowIndex => $rowValue) {
            foreach ($rowValue as $colIndex => $colValue) {
                $attributes = '';
                foreach ($options['col'] as $key => $value) {
                    if ($key !== 'tag') {
                        $value = is_callable($value) ? $value($colIndex,
                            $options) : $value;
                        $attributes .= !empty($value) ? ' ' . $key . '="' . $value . '"' : '';
                    }
                }

                $cols .= sprintf($options['col']['tag'], $attributes);
            }
            $i++;
            if ($i > 0) {
                break;
            }
        }

        return $cols;
    }

    /**
     * @param        $data
     * @param string $row
     * @param string $col
     * @param null   $options
     *
     * @return string
     */
    public function getGrid($data, $row = 'tr', $col = 'td', $options = null)
    {
        $rows = '';

        if (!is_array($data)) {
            return $rows;
        }


        foreach ($data as $rowIndex => $rowValue) {

            // Attribute for tr
            $attributes[$row] = '';
            foreach ($options[$row] as $key => $value) {
                if ($key !== 'tag') {

                    $value = is_callable($value) ?
                        $value($rowIndex, $rowValue, $options) : $value;

                    $attributes[$row] .= !empty($value) ? ' ' . $key . '="' . $value . '"' : '';
                }
            }

            $cols = '';
            $skipCols = 0;
            $skipCols = $this->isShowRowIndex() ? $skipCols + 1 : $skipCols;
            $skipCols = $this->isShowRowCheckbox() ? $skipCols + 1 : $skipCols;

            $i = 0;
            foreach ($rowValue as $colIndex => $colValue) {

                // Attribute for td
                $attributes[$col] = '';
                foreach ($options[$col] as $key => $value) {
                    if ($key !== 'tag' && $key !== 'value') {

                        $value = is_callable($value) ?
                            $value($rowIndex, $colIndex, $colValue,
                                $options) : $value;

                        $attributes[$col] .= !empty($value) ? ' ' . $key . '="' . $value . '"' : '';
                    }
                }

                // Value for td
                if (($row == 'thead_tr' && !$this->theadUsesValue) ||
                    ($row == 'tfoot_tr' && !$this->tfootUsesValue)
                ) {
                    if ($rowIndex === 'search') {
                        $colValue = $i >= $skipCols ? $colValue : '';
                    } else {
                        $colValue = $i >= $skipCols ? $colIndex : '';
                    }

                } else {
                    $colValue = isset($options[$col]['value']) && is_callable($options[$col]['value']) ?
                        $options[$col]['value']($rowIndex, $colIndex,
                            $colValue,
                            $options) : $colValue;
                }

                $cols .= sprintf($options[$col]['tag'], $attributes[$col],
                    $colValue);

                $i++;
            }

            $rows .= sprintf($options[$row]['tag'], $attributes[$row], $cols);
        }

        return $rows;
    }

    public function addRowIndex()
    {
        // Header
        $theadData = $this->getTheadData();

        foreach ($theadData as $rowIndex => &$cols) {
            array_unshift($cols, '');
        }
        $this->setTheadData($theadData);


        // Body
        $data = $this->getData();
        foreach ($data as $rowIndex => &$cols) {
            array_unshift($cols, $rowIndex);
        }
        $this->setData($data);

        // Footer
        $tfootData = $this->getTfootData();

        foreach ($tfootData as $rowIndex => &$cols) {
            array_unshift($cols, '');
        }
        $this->setTfootData($tfootData);
    }

    public function addRowCheckbox()
    {
        $options = $this->getOptions();

        // Header
        $theadData = $this->getTheadData();

        foreach ($theadData as $rowIndex => &$cols) {
            array_unshift($cols, '');
        }
        $this->setTheadData($theadData);


        // Body
        $data = $this->getData();
        foreach ($data as $rowIndex => &$cols) {

            $checkbox = sprintf($options['checkbox']['tag'], $this->getCheckboxName(),
                $cols[$this->getPrimaryKey()]);

            array_unshift($cols, $checkbox);
        }
        $this->setData($data);

        // Footer
        $tfootData = $this->getTfootData();

        foreach ($tfootData as $rowIndex => &$cols) {
            array_unshift($cols, '');
        }
        $this->setTfootData($tfootData);
    }

    public function addColSearch()
    {
        $data = $this->getTheadData();
        $firstRow = array_slice($data, 0, 1);
        $key = key($firstRow);

        $skipCols = 0;
        $skipCols = $this->isShowRowIndex() ? $skipCols+1 : $skipCols;
        $skipCols = $this->isShowRowCheckbox() ? $skipCols+1 : $skipCols;

        $i = 0;
        $searchRow = [];
        foreach ($firstRow[$key] as $colIndex => $col) {
            if ($i >= $skipCols) {
                $searchRow[$colIndex] = '<input type="text" name="' . $colIndex . '" placeholder="'.$colIndex.'">';
            } else {
                $searchRow[$colIndex] = '';
            }
            $i++;
        }

        $this->setTheadData($data + ['search' => $searchRow]);
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->make();
    }

}