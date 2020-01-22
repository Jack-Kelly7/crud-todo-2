var app = new Vue({
    el: '#app',
    data: {
        errorMsg: "",
        successMsg: "",
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        todos: [],
        newTodo: {todo: "", description: "", created_at: ""},
        currentTodo: {}
    },
    mounted: function(){
        this.retrieveTodos();
    },
    methods: {
        retrieveTodos(){
            axios.get("php/retrieve_todo.php").then(function(response){
                if(response.data.error){
                    app.errorMsg = response.data.message;
                } else {
                    app.todos = response.data.todos;
                }
            });
        },
        createTodo(){
            var formData = app.toFormData(app.newTodo);
            axios.post("php/create_todo.php", formData).then(function(response){
                app.newTodo = {todo: "", description: "", created_at: ""};
                if(response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.successMsg = response.data.message;
                    app.retrieveTodos();
                }
            });
        },
        updateTodo(){
            var formData = app.toFormData(app.currentTodo);
            axios.post("php/update_todo.php", formData).then(function(response){
                app.currentTodo = {};
                if(response.data.error){
                    app.errorMsg = response.data.message;
                } else {
                    app.successMsg = response.data.message;
                    app.retrieveTodos();
                }
            });
        },
        deleteTodo(){
            var formData = app.toFormData(app.currentTodo);
            axios.post("php/delete_todo.php", formData).then(function(response){
                app.currentTodo = {};
                if(response.data.error){
                    app.errorMsg = response.data.message;
                } else {
                    app.successMsg = response.data.message;
                    app.retrieveTodos();
                }
            });
        },
        toFormData(obj){
            var fd = new FormData();
            for(var i in obj){
                fd.append(i,obj[i]);
            }
            return fd;
        },
        selectTodo(todo){
            app.currentTodo = todo;
        },
        clearMsg(){
            app.errorMsg = "";
            app.successMsg = "";
        }
    }
});