import mock from "@/fake-db/mock.js"

// Contact
let data = {
  tasks: [
    {
      "id": 10,
      "title": "Refactor Code",
      "desc": "Pie liquorice wafer cotton candy danish. Icing topping jelly-o halvah pastry lollipop.",
      "isImportant": true,
      "isStarred": false,
      "tags": ["doc", "backend"],
      "isCompleted": false,
      "isTrashed": false
    },
    {
      "id": 11,
      "title": "Submit Report",
      "desc": "Donut tart toffee cake cookie gingerbread. Sesame snaps brownie sugar plum candy canes muffin cotton candy.",
      "isImportant": false,
      "isStarred": true,
      "tags": ["frontend", "doc"],
      "isCompleted": false,
      "isTrashed": false
    },
    {
      "id": 15,
      "title": "Send PPT 🎁",
      "desc": "Dragée gummi bears tiramisu brownie cookie. Jelly beans pudding marzipan fruitcake muffin. Wafer gummi bears lollipop pudding lollipop biscuit.",
      "isImportant": true,
      "isStarred": true,
      "tags": ["backend", "doc"],
      "isCompleted": false,
      "isTrashed": false
    },
    {
      "id": 18,
      "title": "Skype Tommy",
      "desc": "Tart oat cake sesame snaps lollipop croissant cake biscuit.",
      "isImportant": false,
      "isStarred": false,
      "tags": ["bug"],
      "isCompleted": true,
      "isTrashed": false
    },
    {
      "id": 20,
      "title": "Pick up Natasha 😁",
      "desc": "Sweet roll toffee dragée cotton candy jelly beans halvah gingerbread jelly-o. Ice cream bear claw sugar plum powder.",
      "isImportant": true,
      "isStarred": true,
      "tags": [],
      "isCompleted": false,
      "isTrashed": false
    },
    {
      "id": 23,
      "title": "Meet Jane ❤️",
      "desc": "Toffee sugar plum oat cake tiramisu tart bonbon gingerbread cheesecake cake. ",
      "isImportant": true,
      "isStarred": true,
      "tags": ["frontend", "backend", "doc"],
      "isCompleted": false,
      "isTrashed": false
    },
    {
      "id": 25,
      "title": "Promot Products",
      "desc": "Gummi bears bear claw cake tiramisu gummies tiramisu apple pie chocolate jujubes. ",
      "isImportant": true,
      "isStarred": false,
      "tags": [],
      "isCompleted": false,
      "isTrashed": true
    },
    {
      "id": 28,
      "title": "Fix Project",
      "desc": "Cookie fruitcake macaroon muffin apple pie chocolate bar toffee oat cake. Icing chocolate danish.",
      "isImportant": false,
      "isStarred": false,
      "tags": ["backend"],
      "isCompleted": false,
      "isTrashed": true
    },
    {
      "id": 29,
      "title": "Remove redundant files",
      "desc": "Brownie jelly beans tootsie roll brownie marshmallow. Sesame snaps halvah marzipan chocolate cake. Icing bear claw pie apple pie.",
      "isImportant": false,
      "isStarred": false,
      "tags": [],
      "isCompleted": true,
      "isTrashed": true
    },
    {
      "id": 33,
      "title": "Fix Responsiveness 💻",
      "desc": "Jelly topping toffee bear claw. Sesame snaps lollipop macaroon croissant cheesecake pastry cupcake.",
      "isImportant": true,
      "isStarred": false,
      "tags": ["frontend"],
      "isCompleted": false,
      "isTrashed": false
    },
  ],
  taskTags: [
    { id: 5,text: 'Frontend' ,value : 'frontend', color: 'primary' },
    { id: 7,text: 'Backend', value: 'backend', color: 'warning'},
    { id: 8,text: 'Doc', value: 'doc', color: 'success'},
    { id: 11,text: 'Bug', value: 'bug', color: 'danger' },
  ]
}

// POST : Add new Tasks
mock.onPost("/api/apps/todo/tasks/").reply((request) => {

  // Get task from post data
  let task = JSON.parse(request.data).task

  const length = data.tasks.length
  let lastIndex = 0
  if(length){
    lastIndex = data.tasks[length - 1].id
  }
  task.id = lastIndex + 1

  data.tasks.push(task)

  return [201, {id: task.id}]
})

// GET: Fetch Todos
mock.onGet("api/apps/todo/tasks").reply((request) => {

  const filter = request.params.filter

  const filteredTasks = data.tasks.filter((task)=> {

    // If filter == all
    if(filter === "all") return !task.isTrashed

      // If filter == starred
    if(filter === "starred") return !task.isTrashed && task.isStarred

    // If filter == important
    if(filter === "important") return !task.isTrashed && task.isImportant

    // If filter == completed
    if(filter === "completed") return !task.isTrashed && task.isCompleted

    // If filter == trashed
    if(filter === "trashed") return task.isTrashed

    else return task.tags.includes(filter)

  })


  return [200, JSON.parse(JSON.stringify(filteredTasks)).reverse()]
})

// GET: Fetch tags
mock.onGet("api/apps/todo/tags").reply(() => {
  return [200, JSON.parse(JSON.stringify(data.taskTags))]
})

// POST: Update Task
mock.onPost(/\/api\/apps\/todo\/task\/\d+/).reply((request) => {

  const taskId = request.url.substring(request.url.lastIndexOf("/")+1)

  let task = data.tasks.find((task) => task.id == taskId)
  // task.title = JSON.parse(request.data).task.title
  Object.assign(task, JSON.parse(request.data).task)

  return [200, task]
})
