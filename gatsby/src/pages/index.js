import React from "react"
import { Link, graphql } from "gatsby"
import Layout from "../components/layout"
import SEO from "../components/seo"

const Index = ({ data }) => {
  return (
    <Layout>
      <SEO title="home" />
      <h1>Bigfoot is out there</h1>
      <h4>Recently reported sightings</h4>
      {data.bigFootSightings.bigFootSightings.edges.map(({ node }) => (
        <div class='sighting-block' key={node.id}>
          <Link to={`/sighting/${node.id.split("/")[4]}`}>
            <p><strong>{node.title}</strong></p>
          </Link>
          <div>
            {node.description.substring(0, 100)}...
          </div>
          <div class='sighting-details'>
            <em>Reported by <strong>{node.owner.username}</strong>.</em>
          </div>
          <div class='sighting-details'>
          {node.comments.totalCount} comments since {node.createdAt.substring(0, 10)}.
          </div>
        </div>
      ))}
    </Layout>
  )
}

export default Index 

export const query = graphql`
  query {
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
`
