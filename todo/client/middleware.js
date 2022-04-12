class Middleware {
   constructor() {
      this.count = 0;
      this.url = '/rest/todo/restmiddleware.php';
   }

   create(todo, callback) {
      const body = JSON.stringify(todo);
      this.connect(this.url, 'POST', body, (result) => {
         this.read(callback);
      })
      callback(); 
   }

   delete(id, callback) {
      const url = this.url + '?id=' + id;
      this.connect(url, 'DELETE', null, (result) => {
         this.read(callback);
      })
   }

   complete(id, callback) {
      const url =  this.url + '?id=' + id;
      this.connect(url, 'PUT', null, (result) => {
         this.read(callback);
      }) 
   }

   read(callback) {
      this.connect(this.url, 'GET', null, (response) => {
         const data = JSON.parse(response);
         callback(data);
      })
   }

   connect(url, method, body, callback) {
      const xhr = new XMLHttpRequest();
      xhr.open(method, url);
      xhr.onload = () => {
         if (xhr.status != 200) { 
            alert(`Error ${xhr.status}: ${xhr.statusText}`); 
          } else { 
            callback(xhr.response);
          }
      }
      if (body) {
         xhr.send(body);
      } else {
         xhr.send();
      }  
   }
}