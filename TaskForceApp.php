<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <style>
        .basic-grid{
            text-align: center;
            border: solid 1px black;
        }
    </style>
</head>
<body>
    <div class="basic-grid">
        <form action="TaskForceApp.php" method="POST">
            <label for="newTask">Add a task</label><br>
            <input type="text" id="newTask" name="newTask"></input>
            <input type="submit" value="Submit" name="submit"></input>
        </form>
    </div>
    <div class="basic-grid">
        <form action="TaskForceApp.php" method="POST">
            <label for="newTask">Delete a task by number</label><br>
            <input type="text" id="idToRemove" name="idToRemove"></input>
            <input type="submit" value="Delete" name="delete"></input>
        </form>
    </div>
    <div class="basic-grid">
        <form action="TaskForceApp.php" method="POST">
            <label for="newTask">Mark complete by number</label><br>
            <input type="text" id="idToUpdate" name="idToUpdate"></input>
            <input type="submit" value="Update" name="updateStatus"></input>
        </form>
    </div>
    <div class="basic-grid">
        <form action="TaskForceApp.php" method="POST">
            <label for="newTask">Update task by number</label><br>
            <input type="text" id="idToUpdate" name="idToUpdate">Task ID</input>
            <input type="text" id="updatedTask" name="updatedTask">New Task</input>
            <input type="submit" value="Update" name="updateTask"></input>
        </form>
    </div>
    <div class="basic-grid">
        <?php
            $filename = "tasks.txt";
            if(file_exists($filename)){
                $content = trim(file_get_contents($filename));


                if (!empty($content)) {
            
            
                    $tasks = json_decode($content, true); 
            
            
                    if (!is_array($tasks)) {
                        $tasks = [];
                    }
                }
            
            }

            if(isset($_POST['submit']))
            {
                if ($_POST["newTask"] != null){
                    $newTask = [
                        "task" => $_POST["newTask"],
                        "done" => false
                    ];
    
                    $tasks[] = $newTask;
                }

                file_put_contents($filename, json_encode($tasks, JSON_PRETTY_PRINT));

                header("Location: redirect.php");
                exit();
            } 

            if(isset($_POST['delete'])){
                $toDelete = $_POST["idToRemove"]; 
                $toDelete--;
                unset($tasks[$toDelete]);
                $tasks = array_values($tasks);

                file_put_contents($filename, json_encode($tasks, JSON_PRETTY_PRINT));

                header("Location: redirect.php");
                exit();
            }

            if(isset($_POST['updateStatus'])){
                $toUpdate = $_POST["idToUpdate"];
                $toUpdate--;
                if($tasks[$toUpdate]['done'] == false)
                $tasks[$toUpdate]['done'] = true;
                else if($tasks[$toUpdate]['done'] == true)
                $tasks[$toUpdate]['done'] = false;

                file_put_contents($filename, json_encode($tasks, JSON_PRETTY_PRINT));

                header("Location: redirect.php");
                exit();
            }

            if(isset($_POST['updateTask'])){
                $toUpdate = $_POST["idToUpdate"];
                $toUpdate--;
                $updatedTask = $_POST["updatedTask"];

                $tasks[$toUpdate]['task'] = $updatedTask;

                file_put_contents($filename, json_encode($tasks, JSON_PRETTY_PRINT));

                header("Location: redirect.php");
                exit();
            }
                
            $itemCount = 0;
            foreach ($tasks as $t){
                if ($t["done"] == true){
                    $itemCount++;
                    echo "$itemCount $t[task]: Done <br>";
                }
                else if ($t["done"] == false){
                    $itemCount++;
                    echo "$itemCount $t[task]: To do <br>";
                }
            };
        ?>
    </div>
</body>
</html>