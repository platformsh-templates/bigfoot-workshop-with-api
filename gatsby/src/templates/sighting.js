import React from "react"
import Layout from "../components/layout"
import { graphql } from "gatsby"

const Sighting = ({ data }) => {
  const post = data.bigFootSightings.bigFootSighting
  const location = `https://gps-coordinates.org/my-location.php?lat=${post.latitude}&lng=${post.longitude}`;
  return (
    <Layout>
      <div>
        <h1>{post.title}</h1>
        <div>
          {post.description}
        </div>
      </div>
      <div class='sighting-details'>
        <strong>Confidence:</strong>
        {` `}
        {post.confidenceIndex}
      </div>

      <div class='sighting-details'>
        <strong>Location:</strong>
        {` `}
        <a href={location} target="_blank">({post.latitude}, {post.longitude})</a>
      
      </div>
      <div class='sighting-details'>
          <em>Reported by <strong>{post.owner.username}</strong>.</em>
      </div>
      <div class='sighting-details'>
          {post.comments.totalCount} comments since {post.createdAt.substring(0, 10)}.
      </div>
      <hr class='divider'></hr>
      <h2>Recent comments</h2>
      {post.comments.edges.map(({ node }) => (
        <div class='sighting-block' key={node.id}>
          <p><strong>{node.createdAt.substring(0, 10)}</strong></p>
          <div>
            {node.content}
          </div>
          <div class='sighting-details'>
            <em>Reported by <strong>{node.owner.username}</strong>.</em>
          </div>
        </div>
      ))}


    </Layout>
  )
}

export default Sighting

export const query = graphql`
  query($id: ID!, $first: Int) {
    bigFootSightings {
      bigFootSighting(id: $id) {
        title
        description
        latitude
        longitude
        confidenceIndex
        createdAt
        owner {
          id
          username
          email
        }
        comments(first: $first) {
          totalCount
          edges {
            node {
              id
              content
              createdAt
              owner {
                id
                username
                email
              }
            }
          }
        }
      }
    }
  }
`
