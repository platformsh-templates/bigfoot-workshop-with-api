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
        <div className='sighting-block' key={node.id}>
            {/*TODO use dynamic index depending if on PSH (4) or local (3)*/}
          <Link to={`/sighting/${node.id.split("/")[3]}`}>
            <p><strong>{node.title}</strong></p>
          </Link>
          <div>
            {node.description.substring(0, 100)}...
          </div>
          <div className='sighting-details'>
            <em>Reported by <strong>{node.owner.username}</strong>.</em>
          </div>
          <div className='sighting-details'>
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
