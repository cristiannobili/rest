
class Presenter {
   constructor() {
      this.todos = new Todos(() => {
         document.querySelector("#date").value = new Date().toISOString().split('T')[0];
         document.querySelector("#send")
         .addEventListener('click', () => {
            this.add();
         });
         this.refresh();
      });
      
   }

   add() {
      const title = document.querySelector("#title").value;
      document.querySelector("#title").value = "";
      const date = document.querySelector("#date").value;
      this.todos.add(title, date, () => {
         this.refresh();
      });
   }

   refresh() {
      
      let template = `
         <li class="element">
            <div class="title %COMPLETE">%TITLE</div>
            <button class="complete" onclick="presenter.complete(%ID)">V</button>
            <button class="delete" onclick="presenter.remove(%ID)">X</button>
         </li>
      `;
      let html = "";
      this.todos.get().forEach(element => {
         let date = new Date(element.date);

         let row = template.replace("%TITLE", date.toLocaleDateString() + ": " + element.title);
         row = row.replace("%ID", element.id);
         row = row.replace("%ID", element.id);
         row = row.replace("%COMPLETE", element.completed == '1' ? "complete" : "");
         row = row.replace("%COMPLETE", element.completed == '1' ? "complete" : "");
         html += row;
      });
      document.querySelector('ul').innerHTML = html;
   }

   remove(index) {
      this.todos.remove(index, () => {
         this.refresh();
      });
   }

   complete(index) {
      this.todos.complete(index, () => {
         this.refresh();
      });
   }

}

let presenter;
window.addEventListener('load', () => {
   presenter = new Presenter();
})

