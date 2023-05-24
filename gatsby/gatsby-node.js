const path = require(`path`)

exports.createPages = ({ graphql, actions }) => {
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
      let newID = originalPathParts[3]
      createPage({
        path: `/sighting/${newID}`,
        component: path.resolve(`./src/templates/sighting.js`),
        context: {
          // This is the $slug variable
          // passed to blog-post.js
          id: node.id,
          first: 20,
        },
      })
    })
  })
}
