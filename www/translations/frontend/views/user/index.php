<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div id="app">
        <user-table :users="users"></user-table>
    </div>

    <script>
        Vue.component('user-table', {
            props: ['users'],
            template: `
              <div class="row">
                <div class="col-12">
                  <table class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Actions</th> <!-- Actions Column -->
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{ user.id }}</td>
                      <td>{{ user.username }}</td>
                      <td>{{ user.password }}</td>
                      <td>
                        <button class="btn btn-warning btn-sm" @click="updateUser(user.updateLink)">Update</button>
                        <button class="btn btn-danger btn-sm" @click="deleteUser(user)">Delete</button>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            `,
            methods: {
                deleteUser(user) {
                    const deleteLink = user.deleteLink;
                    const id= user.id;
                    const csrf_token = document.getElementsByName('csrf-token')[0].getAttribute('content');
                    fetch(deleteLink, {
                        method: 'POST', // Use POST method for deletion
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: id, _csrf: yii.getCsrfToken() }) // Send user ID in the request body
                    })
                        .then(response => {
                            if (response.ok) {
                                // Handle successful deletion, e.g., refresh the user list or notify the user

                                // You might want to remove the user from the users array
                                this.$emit('user-deleted');
                            } else {
                                // Handle errors
                                alert('There was an error deleting the user.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('There was a problem with the delete request.');
                        });
                },
                updateUser(link) {
                    // Redirect to the update link
                    window.location.href = link;
                }
            }
        });


        new Vue({
            el: '#app',
            data: {
                users: [<?php foreach ($models as $model): ?>
                    {
                        id: <?= $model->id ?>,
                        username: <?= json_encode($model->username) ?>,
                        email: <?= json_encode($model->email) ?>,
                        updateLink: <?= json_encode((Yii::$app->urlManager->createAbsoluteUrl(['user/update', 'id' => $model->id]))) ?>,
                        deleteLink: <?= json_encode((Yii::$app->urlManager->createAbsoluteUrl(['user/delete', 'id' => $model->id]))) ?>,
                    },
                        <?php endforeach; ?>]
            },
            mounted() {
                console.log(this.users); // Log to check the data
            }
        });
    </script>
</div>
