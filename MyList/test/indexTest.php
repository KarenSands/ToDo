<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of indexTest
 *
 * @author karen
 */
class indexTest extends PHPUnit_Framework_TestCase {
//    use PHPUnit\Framework\TestCase;
//use PHPUnit\DbUnit\TestCaseTrait;
////    use TestCaseTrait;
//    /**
//     * @var \RemoteWebDriver
//     */
//    protected $webDriver;

    public function setUp() {
        $db = mysqli_connect("localhost", "root", "", "todo");
    }

    public function tearDown() {
//        $this->webDriver->close();
    }

    //PRUEBA INSERTAR TAREA
    public function testAddEntry()
    {
        $task = new InsertTask();
        $task->InsertTask("leer libro");

        $queryTable = $this->getConnection()->createQueryTable(
            'task', 'SELECT task FROM task where task = "leer libro"'
        );
        $expectedTable = $this->createFlatXmlDataSet("expectedInsert.xml")
                              ->getTable("task");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    //PRUEBA BORRAR TAREA
        public function testDeleteEntry()
    {
        $task = new DeleteTask();
        $query='SELECT id FROM task where task="leer libro"';
        $task->DeleteTask($query);

        $queryTable = $this->getConnection()->createQueryTable(
            'task', 'SELECT task FROM task where task = "leer libro"'
        );
        $expectedTable = $this->createFlatXmlDataSet("expectedDelete.xml")
                              ->getTable("task");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    //PRUEBA COMPLETAR TAREA
       public function testCompleteEntry()
    {
          $task = new CompleteTask();
        $task->CompleteTask("leer libro");

        $queryTable = $this->getConnection()->createQueryTable(
            'task', 'SELECT task FROM com where task = "leer libro"'
        );
        $expectedTable = $this->createFlatXmlDataSet("expectedComplete.xml")
                              ->getTable("task");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    //PRUEBA MOSTRAR TAREAS
    public function testShowTasks()
    {

        $queryTable = $this->getConnection()->createQueryTable(
            'task', 'SELECT task FROM task'
        );
        $expectedTable = $this->createFlatXmlDataSet("expectedShow.xml")
                              ->getTable("task");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}
