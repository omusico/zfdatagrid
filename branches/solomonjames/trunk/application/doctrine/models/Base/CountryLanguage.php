<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Model_CountryLanguage', 'master');

/**
 * Model_Base_CountryLanguage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $countrycode
 * @property string $language
 * @property enum $isofficial
 * @property float $percentage
 * 
 * @package    Doctrine
 * @subpackage 
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Model_Base_CountryLanguage extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('CountryLanguage');
        $this->hasColumn('countrycode', 'string', 3, array(
             'type' => 'string',
             'fixed' => 1,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '3',
             ));
        $this->hasColumn('language', 'string', 30, array(
             'type' => 'string',
             'fixed' => 1,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '30',
             ));
        $this->hasColumn('isofficial', 'enum', 1, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'T',
              1 => 'F',
             ),
             'primary' => false,
             'default' => 'F',
             'notnull' => true,
             'autoincrement' => false,
             'length' => '1',
             ));
        $this->hasColumn('percentage', 'float', 4, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0.0',
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}