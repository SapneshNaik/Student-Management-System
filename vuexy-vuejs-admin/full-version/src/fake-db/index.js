import mock from './mock'


import "./data/card/index.js"
import "./data/table/index.js"
import "./data/data-list/index.js"
import "./data/user-management/index.js"
import "./data/user/index.js"

// Apps
import "./data/apps/index.js"

mock.onAny().passThrough(); // forwards the matched request over network
