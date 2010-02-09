<?php

/**
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license
 * It is  available through the world-wide-web at this URL:
 * http://www.petala-azul.com/bsd.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to geral@petala-azul.com so we can send you a copy immediately.
 *
 * @package    Bvb_Grid
 * @copyright  Copyright (c)  (http://www.petala-azul.com)
 * @license    http://www.petala-azul.com/bsd.txt   New BSD License
 * @version    $Id$
 * @author     Bento Vilas Boas <geral@petala-azul.com >
 */



class Bvb_Grid_Deploy_Xml extends Bvb_Grid_Data implements Bvb_Grid_Deploy_Interface
{

    const OUTPUT = 'xml';

    public $templateInfo;

    public $deploy = array();


    /**
     *
     * @param array $options
     */
    function __construct ($options = array('download'))
    {

        if (! in_array(self::OUTPUT, $this->export)) {
            echo $this->__("You dont' have permission to export the results to this format");
            die();
        }

        $this->_setRemoveHiddenFields(true);
        parent::__construct($options);

    }

    function buildTitltesXml ($titles)
    {
        $grid = '';

        $grid .= "    <fields>\n";

        foreach ($titles as $title) {

            $grid .= "        <" . $title['field'] . "><![CDATA[" . $title['value'] . "]]></" . $title['field'] . ">\n";

        }

        $grid .= "    </fields>\n";

        return $grid;

    }


    function buildSqlexpXml ($sql)
    {

        $grid = '';

        if (is_array($sql)) {
            $grid .= "    <sqlexp>\n";


            foreach ($sql as $exp) {
                $grid .= "        <" . $exp['field'] . "><![CDATA[" . $exp['value'] . "]]></" . $exp['field'] . ">\n";
                ;
            }

            $grid .= "    </sqlexp>\n";
        }

        return $grid;

    }


    function buildGridXml ($grids)
    {

        $grid = '';

        $grid .= "    <results>\n";


        foreach ($grids as $value) {
            $grid .= "        <row>\n";
            foreach ($value as $final) {
                $grid .= "            <" . $final['field'] . "><![CDATA[" . $final['value'] . "]]></" . $final['field'] . ">\n";
            }
            $grid .= "        </row>\n";
        }

        $grid .= "    </results>\n";

        return $grid;
    }


    function deploy ()
    {

        $this->setPagination(0);
        parent::deploy();

        $grid = '';
        $grid .= '<?xml version="1.0" encoding="' . $this->charEncoding . '"?>' . "\n";
        $grid .= "<grid>\n";

        $grid .= self::buildTitltesXml(parent::_buildTitles());
        $grid .= self::buildGridXml(parent::_buildGrid());
        $grid .= self::buildSqlexpXml(parent::_buildSqlExp());

        $grid .= "</grid>";


        if (! isset($this->deploy['save'])) {
            $this->deploy['save'] = false;
        }

        if (! isset($this->deploy['download'])) {
            $this->deploy['download'] = false;
        }

        if ($this->deploy['save'] != 1 && $this->deploy['download'] != 1) {
            header("Content-type: application/xml");
        }


        if (! isset($this->deploy['save']) && ! isset($this->options['download'])) {
            echo $grid;
            die();
        }

        if (empty($this->deploy['name'])) {
            $this->deploy['name'] = date('H_m_d_H_i_s');
        }

        if(substr($this->deploy['name'],-4)=='.xml')
        {
            $this->deploy['name'] = substr($this->deploy['name'],0,-4);
        }

        $this->deploy['dir'] = rtrim($this->deploy['dir'], '/') . '/';

        if (! is_dir($this->deploy['dir'])) {
            throw new Bvb_Grid_Exception($this->deploy['dir'] . ' is not a dir');
        }

        if (! is_writable($this->deploy['dir'])) {
            throw new Bvb_Grid_Exception($this->deploy['dir'] . ' is not writable');
        }

        file_put_contents($this->deploy['dir'] . $this->deploy['name'] . ".xml", $grid);


        if ($this->deploy['download']==1) {
            header('Content-Disposition: attachment; filename="' . $this->deploy['name'] . '.xml"');
            readfile($this->deploy['dir'] . $this->deploy['name'] . '.xml');
        }


        if ($this->deploy['save']!=1) {
            unlink($this->deploy['dir'] . $this->deploy['name'] . '.xml');
        }

        die();
    }

}

