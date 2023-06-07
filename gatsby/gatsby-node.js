const path = require(`path`)


exports.createPages = ({ graphql, actions, store }) => {
  const { setPluginStatus } = actions;
  const state = store.getState();
  const plugin = state.flattenedPlugins.find(plugin => plugin.name === "gatsby-plugin-manifest");

  let indexFromPlugin = {...plugin.pluginOptions.index};

  console.log(indexFromPlugin);
  const { createPage } = actions
  return graphql(`
    {
      bigFootSightings {
        bigFootSightings {
          edges {
            node {
              id
              description
              title
              latitude
              longitude
              createdAt
              owner {
                id
                username
                email
              }
              comments {
                totalCount
              }
            }
          }
        }
      }
    }
  `).then(result => {
    result.data.bigFootSightings.bigFootSightings.edges.forEach(({ node }) => {
      let originalPathParts = node.id.split("/")
      let newID = originalPathParts[indexFromPlugin]
      createPage({
        path: `/sighting/${newID}`,
        component: path.resolve(`./src/templates/sighting.js`),
        context: {
          // This is the $slug variable
          id: node.id,
          first: 20,
        },
      })
    })
  })
}
