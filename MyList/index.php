<?php 

	$errors = "";
	// connect to database
	$db = mysqli_connect("localhost", "root", "", "todo");
      //  $timestamp= date("Y-m-d H:i:s");
/*---------------------------------------------------------------------------------------------------------------------*/
    // insert a quote in task if submit button is clicked
        function InsertTask($task, $type, $imp){
            $query = "INSERT INTO task (task,tipo,importancia) VALUES ('$task','$type','$imp')";
            return ($query);
        }   
        if (isset($_POST['submit'])) {
             	if (empty($_POST['task'])&& empty($_POST['type'])&&empty($_POST['imp'])) {
			$errors = "Porfavor llena los campos";
		}else{
                    mysqli_query($db,InsertTask($_POST['task'],$_POST['type'],$_POST['imp']));
                    header('location: index.php');
                }
            }
/*---------------------------------------------------------------------------------------------------------------------*/                                       
	// delete task
        function DeleteTask($id){
            $query="DELETE FROM task WHERE id=".$id;
            return ($query);
        }    
	if (isset($_GET['del_task'])) {
		mysqli_query($db, DeleteTask($_GET['del_task']));
		header('location: index.php');
	}
/*---------------------------------------------------------------------------------------------------------------------*/
	//COMPLETE TASK
// insert a quote in com if submit button is clicked
        function CompleteTask($task, $type,$imp,$fecha){
            $query = "INSERT INTO com (task,tipo,importancia,fecha) VALUES ('$task','$type','$imp','$fecha')";
            return($query);
        } 
    if (isset($_GET['cel_task'])) {
        mysqli_query($db, CompleteTask($_GET['task'],$_GET['type'],$_GET['imp'],$_GET['fecha']));
        header('location: index.php');
        
    }
/*---------------------------------------------------------------------------------------------------------------------*/
// select all tasks if page is visited or refreshed
        function ShowTasks(){
            $query = "SELECT * FROM task";
            return($query);
        }
	$tasks = mysqli_query($db, ShowTasks());
//select completed tasks
        function ShowComTasks(){
            $query = "SELECT * FROM com";
            return($query);
        }
	$comtasks = mysqli_query($db, ShowComTasks());
?>
<!DOCTYPE html>
<html>

<head>
	<title>MyList</title>
	<link rel="stylesheet" type="text/css" href="../other/style.css">
</head>

<body>

	<div class="heading">
		<h2 style="font-style: 'Hervetica';">MyList</h2>
	</div>


	<form method="post" action="index.php" class="input_form">
		<?php if (isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
		<?php } ?>
		<h5>tarea</h5><input id="taskname" type="text" name="task" class="task_input">
                <h5>tipo</h5><input id="tasktype" type="text" name="type" class="task_input">
                <h5>importancia</h5><input id="taskimp" type="text" name="imp" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Agregar Tarea</button>
	</form>


	<table>
		<thead>
                    <p id="title"> Task list</p>
			<tr>
				<th>N</th>
				<th>Tasks</th>
                                <th>Type</th>
                                <th>Importance</th>
                                <th>Date</th>
				<th style="width: 60px;">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
				<tr id="tareas">
					<td class="id"> <?php echo $i; ?> </td>
                                        <td class="task"> <?php echo $row['task'];?></td>
                                        <td class="type"> <?php echo $row['tipo'];?></td>
                                        <td class="imp"> <?php echo $row['importancia'];?></td>
                                        <td class="fecha"> <?php echo $row['fecha'];?></td>
                                        <td class="delete"> 
						<a class="Del_btn" href="index.php?del_task=<?php echo $row['id'] ?>">x</a>
                                                <a class="Com_btn" href="index.php?cel_task=<?php echo $row['id'] ?>&task=<?php echo $row['task'];?>&type=<?php echo $row['tipo'];?>&imp=<?php echo $row['importancia'];?>&fecha=<?php echo $row['fecha'];?>">c</a>         
                    </td>
				</tr>
			<?php $i++; } ?>	
		</tbody>
	</table>
    	<table>
		<thead>
                    <p id="title"> Completed tasks</p>
			<tr>
				<th>N</th>
				<th>Tasks</th>
                                <th>Type</th>
                                <th>Importance</th>
                                <th>Date</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; while ($row = mysqli_fetch_array($comtasks)) { ?>
				<tr id="completas">
					<td class="id"> <?php echo $i; ?> </td>
                                        <td class="comtask"> <?php echo $row['task'];?></td>
                                        <td class="type"> <?php echo $row['tipo'];?></td>
                                        <td class="imp"> <?php echo $row['importancia'];?></td>
                                        <td class="fecha"> <?php echo $row['fecha'];?></td>
				</tr>
			<?php $i++; } ?>	
		</tbody>
	</table>

</body>
</html>