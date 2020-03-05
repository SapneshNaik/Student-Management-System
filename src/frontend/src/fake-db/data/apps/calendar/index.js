import mock from "@/fake-db/mock.js"

// Contact
let data = {
  events: [
    {
      id: 1,
      title: 'My Event',
      startDate: new Date(new Date() - 1000 * 60 * 60 * 24 * 3),
      endDate: new Date(new Date() - 1000 * 60 * 60 * 24 * 2),
      url: '',
      classes: 'event-success',
      label: 'business'
    },
  ],
  labels: [
    { text: 'Business' ,value : 'business', color: 'success' },
    { text: 'Work', value: 'work', color: 'warning'},
    { text: 'Personal', value: 'personal', color: 'danger'},
  ]
}

// GET : Calendar Events
mock.onGet("/api/apps/calendar/events").reply(() => {
  return [200, data.events]
})

// POST : Add new events
mock.onPost("/api/apps/calendar/events/").reply((request) => {

  // Get event from post data
  let event = JSON.parse(request.data).event

  const length = data.events.length
  let lastIndex = 0
  if(length){
    lastIndex = data.events[length - 1].id
  }
  event.id = lastIndex + 1

  data.events.push(event)

  return [201, {id: event.id}]
})

// GET: Fetch Calendar Labels
mock.onGet("api/apps/calendar/labels").reply(() => {
  return [200, data.labels]
})

// POST: Update Event
mock.onPost(/\/api\/apps\/calendar\/event\/\d+/).reply((request) => {

  let e = JSON.parse(request.data).event
  e.startDate = new Date(e.startDate)
  e.endDate = new Date(e.endDate)

  const eventId = request.url.substring(request.url.lastIndexOf("/")+1)


  let event = data.events.find((event) => event.id == eventId)
  Object.assign(event, e)

  return [200, event]
})

// DELETE: Remove Event
mock.onDelete(/\/api\/apps\/calendar\/event\/\d+/).reply((request) => {

  const eventId = request.url.substring(request.url.lastIndexOf("/")+1)

  const eventIndex = data.events.findIndex((event) => event.id == eventId)
  data.events.splice(eventIndex, 1)
  return [200]
})

// POST: Update Dragged Event
mock.onPost(/\/api\/apps\/calendar\/event\/dragged\/\d+/).reply((request) => {

  const eventId = request.url.substring(request.url.lastIndexOf("/")+1)
  let event = data.events.find((event) => event.id == eventId)
  const payload = JSON.parse(request.data).payload

  const draggedDateStart = new Date(payload.date)

  const eventStartDate = new Date(event.startDate).getTime()
  const eventEndDate = new Date(event.endDate).getTime()

  const diff = draggedDateStart - eventStartDate
  const newEndDate = new Date(eventEndDate + diff)
  event.startDate = draggedDateStart
  event.endDate = newEndDate

  return [200, event]
})
