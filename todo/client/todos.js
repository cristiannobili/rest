
class Todos {
   constructor(callback) {
      this.middleware = new Middleware();
      this.list = [];
      this.reload(callback);
   }

   get() {
      return this.list;
   }

   add(title, date, callback) {
      const todo = {
         title: title,
         date: date
      }
      this.middleware.create(todo, (data) => {
         this.list = data;
         callback();
      });
   }

   remove(index, callback) {
      this.middleware.delete(index, (data) => {
         this.list = data;
         callback();
      });
   }

   complete(index, callback) {
      this.middleware.complete(index, (data) => {
         this.list = data;
         callback();
      });
   }

   reload(callback) {
      this.middleware.read((data) => {
         this.list = data;
         callback();
      })
   }


}