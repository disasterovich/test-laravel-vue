<template>
    <div>
        <h2>Список книг</h2>
        
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#book-create-update-form-modal">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Создать
                </button>
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#books-search-form-modal">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Искать
                </button>
                <button v-if="search.name != '' || search.description != ''" type="button" class="btn btn-primary btn-lg" @click="resetSearchBook();">
                    <span class="glyphicon glyphicon-danger" aria-hidden="true"></span> Сбросить
                </button>
            </div>
        </div>
        
        <!-- Modal book-create-update-form-modal -->
        <div class="modal fade" id="book-create-update-form-modal" tabindex="-1" role="dialog" aria-labelledby="book-create-update-form-modal-label">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                
            <form @submit.prevent="addBook()">
                
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="book-create-update-form-modal-label">{{edit ? 'Редактирование книги (id='+book.id+')' : 'Создание книги'}}</h4>
              </div>
              <div class="modal-body">
                  
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Название" v-model="book.name" />
                    </div>
                    <div class="form-group">
                        <textarea  class="form-control" placeholder="Описание" v-model="book.description" rows="10"></textarea>
                    </div>
                
              </div>
              <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" title="Создать запись">{{edit ? 'Обновить' : 'Создать'}}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
              </div>
                
            </form>
                
            </div>
          </div>
        </div>
        
        
        <!-- Modal books-search-form-modal -->
        <div class="modal fade" id="books-search-form-modal" tabindex="-1" role="dialog" aria-labelledby="books-search-form-modal-label">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                
            <form @submit.prevent="searchBooks()">
                
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="books-search-form-modal-label">Поиск</h4>
              </div>
                <div class="modal-body">
                  
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="search.name" placeholder="Название" />
                    </div>
                    
                    <div class="form-group">И</div>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="search.description" placeholder="Описание" />
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" title="Создать запись">Искать</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
                
            </form>
                
            </div>
          </div>
        </div>
        
        
        <!-- Modal book-view-modal -->
        <div class="modal fade" id="book-view-modal" tabindex="-1" role="dialog" aria-labelledby="book-view-modal-label">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="book-view-modal-label">Просмотр книги (id={{book.id}})</h4>
              </div>
                
                <div class="modal-body">
                  
                    <ul class="list-group">
                        <li class="list-group-item">Название</li>
                        <li class="list-group-item">
                            {{book.name}}
                        </li>
                        <li class="list-group-item">Описание</li>
                        <li class="list-group-item">
                            {{book.description}}
                        </li>
                    </ul>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
                
            </div>
          </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-body">
        
                <!-- Список книг-->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Название</th>
                            <th class="text-center">Описание</th>
                            <th class="text-center">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="book in books" v-bind:key="book.id">
                        <td>{{book.name}}</td>
                        <td>{{book.description}}</td>
                        <td>
                            <a href="#" role="button" @click="deleteBook(book.id)" class="btn btn-danger" title="Удалить запись"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

                            <a href="#" role="button" @click="editBook(book);" class="btn btn-warning" title="Редактировать запись"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                            <a href="#" role="button" @click="viewBook(book);" class="btn btn-primary" title="Просмотр записи"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <nav aria-label="Page navigation">
                  <ul class="pagination">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]">
                      <a href="#" @click="getBooks(pagination.prev_page_url)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>

                    <li class="page-item disabled">
                        <a href="#" class="page-link text-dark">Страница {{pagination.current_page}} из {{pagination.last_page}}</a>
                    </li>

                    <li v-bind:class="[{disabled: !pagination.next_page_url}]">
                      <a href="#" @click="getBooks(pagination.next_page_url)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>
        
            </div>
        </div>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                books: [],
                
                book: {
                    id: '',
                    name: '',
                    description: ''
                },
                
                //book_id: '',
                
                pagination: {},
                edit: false,
                
                search: {
                    name: '',
                    description: '',
                }
                
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        
        created() {
            this.getBooks();
        },
        
        methods: {
            
            getBooks(page_url) {
                
                let self = this;
                page_url = page_url || 'api/books';
                
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    
                    this.books = res.data;
                    self.makePagination(res.meta,res.links);
                })
                .catch(error => console.log(error))
            },
            
            makePagination(meta,links) {
                let pagination = {
                    current_page : meta.current_page,
                    last_page : meta.last_page,
                    next_page_url : links.next,
                    prev_page_url : links.prev,
                };
                
                this.pagination = pagination;
            },
            
            deleteBook(id) {
                if( confirm('Вы уверены что хотите удалить?') ) {
                    fetch('api/books/'+id, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(res => {

                        this.getBooks();
                        
                    })
                    .catch(error => console.log(error))
                }
            },
            
            addBook() {
                if (this.edit === false) {
                    //add
                    fetch('api/books', {
                        method: 'post',
                        body: JSON.stringify(this.book),
                        header: {
                            'content-type' : 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {

                        this.book.name = '';
                        this.book.description = '';
                        this.getBooks();
                        
                    })
                    .catch(error => console.log(error))
                    
                }
                else {
                    //update
                    fetch('api/books', {
                        method: 'put',
                        body: JSON.stringify(this.book),
                        header: {
                            'content-type' : 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {

                        this.book.name = '';
                        this.book.description = '';
                        this.getBooks();
                        
                    })
                    .catch(error => console.log(error))
                }
                
                $('#book-create-update-form-modal').modal('hide');
                this.edit = false;
            },
            
            editBook(book) {
                
                this.edit = true;
                this.book.id = book.id;
                this.book.name = book.name;
                this.book.description = book.description;
                
                $('#book-create-update-form-modal').modal('show');
            },
            
            viewBook(book) {

                this.book.id = book.id;
                this.book.name = book.name;
                this.book.description = book.description;
                
                $('#book-view-modal').modal('show');
            },
            
            searchBooks() {
                
                let self = this;
                
                fetch('api/books/?name='+this.search.name+'&description='+this.search.description)
                .then(res => res.json())
                .then(res => {

                    this.books = res.data;
                    self.makePagination(res.meta,res.links);
                    $('#books-search-form-modal').modal('hide');

                })
                .catch(error => console.log(error))   
            },
            
            resetSearchBook() {
                
                this.search.name = this.search.description = '';
                
                this.getBooks();
            }
        }
        
    }
</script>
