import React, { Component } from 'react';
// import { HydraAdmin } from '@api-platform/admin';
import {HydraAdmin,
  FieldGuesser,
  ListGuesser,
  ResourceGuesser
} from "@api-platform/admin";
import { ReferenceField, TextField } from "react-admin";

let entrypoint = process.env.REACT_APP_PUBLIC_URL;

// const UserList = props => (
//     <ListGuesser {...props}>
//         <FieldGuesser source={"username"} />
//         <FieldGuesser source={"email"} />
//         <FieldGuesser source={"password"} />
//         <FieldGuesser source={"roles"} />
//         <FieldGuesser source={"agreedToTermsAt"} />
//         <FieldGuesser source={"salt"} />
//         <FieldGuesser source={"avatarUrl"} />
//         <FieldGuesser source={"userIdentifier"} />
//     </ListGuesser>
// );

console.log(entrypoint);
if(!entrypoint) { // default entrypoint to current url
  entrypoint = window.location.href;
}

class App extends Component {
  componentDidMount(){
    document.title = process.env.REACT_APP_ADMIN_SITE_NAME || "Admin API Platform.sh";
  }

  render() {
    return <HydraAdmin entrypoint={entrypoint}>
        {/*<ResourceGuesser*/}
        {/*    name="Users"*/}
        {/*    list={UserList}*/}
        {/*/>*/}
    </HydraAdmin>;
  }
}

export default App;
