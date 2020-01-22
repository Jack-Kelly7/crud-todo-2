<?php
    include_once 'config/database.php';
    include_once 'objects/todo.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD Application Using Vue.js, PHP & MySQLi</title>
    <link rel="icon" href="img/icon-dark.png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css">
        #overlay{ position: fixed; top: 0; bottom: 0; left: 0; right: 0; background:rgba(0, 0, 0, 0.6); }
        .table-icon{ height: 32px; width: 32px; }
        .table-icon:hover{ opacity: .8; }
    </style>
</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row bg-dark">
                <div class="col-lg-12">
                    <p class="text-center text-light display-4 pt-2" style="font-size:25px;">"To Do" CRUD Application Using Vue.js, PHP & MySQLi</p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-6">
                    <h3 class="text-info">TO DO LIST:</h3>
                </div>
                <div class="col-lg-6">
                    <button class="btn btn-info float-right" @click="showAddModal=true; clearMsg();">Add New To Do</button>
                </div>
            </div>
            <hr class="bg-info">
            <div class="alert alert-danger" v-if="errorMsg">
                {{ errorMsg }}
            </div>
            <div class="alert alert-success" v-if="successMsg">
                {{ successMsg }}
            </div>

            <!-- Display Records -->
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center bg-info text-light">
                                <th style="width:12%;">To Do:</th>
                                <th style="width:36%;">Description:</th>
                                <th style="width:22%;">Created:</th>
                                <th style="width:7%;">Edit</th>
                                <th style="width:7%;">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="todo in todos">
                                <td>{{ todo.todo }}</td>
                                <td>{{ todo.description }}</td>
                                <td>{{ todo.created_at }}</td>
                                <td><a href="#" class="text-success" @click="showEditModal=true; selectTodo(todo); clearMsg();"><img src="img/edit.png" class="table-icon" alt="edit"></a></td>
                                <td><a href="#" class="text-success" @click="showDeleteModal=true; selectTodo(todo); clearMsg();"><img src="img/del.png" class="table-icon" alt="delete"></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add New To Do -->
        <div id="overlay" v-if="showAddModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New todo</h5>
                        <button type="button" class="close" @click="showAddModal=false;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" name="todo" class="form-control form-control-lg" placeholder="To Do" v-model="newTodo.todo">
                            </div>
                            <div class="form-group">
                                <input type="text" name="description" class="form-control form-control-lg" placeholder="Description" v-model="newTodo.description">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-info btn-block btn-lg" @click="showAddModal=false; createTodo();">Add To Do</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

            <!-- Edit To Do -->
            <div id="overlay" v-if="showEditModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit To Do</h5>
                            <button type="button" class="close" @click="showEditModal=false">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="hidden" name="id" v-model="currentTodo.id">
                                    <input type="text" name="todo" class="form-control form-control-lg" v-model="currentTodo.todo">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="description" class="form-control form-control-lg" placeholder="Description" v-model="currentTodo.description">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-info btn-block btn-lg" @click="showEditModal=false; updateTodo();">Update To Do</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete To Do -->
            <div id="overlay" v-if="showDeleteModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete To Do</h5>
                            <button type="button" class="close" @click="showDeleteModal=false;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <h4 class="text-danger">Are you sure you want to delete this To Do?</h4>
                            <h5>You are deleting '{{ currentTodo.todo }}'</h5>
                            <hr>
                            <button class="btn btn-danger btn-lg" @click="showDeleteModal=false; deleteTodo();">Yes</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-danger btn-lg" @click="showDeleteModal=false;">No</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.min.js"></script>
    <script src="js/todo.js"></script>
</body>
</html>