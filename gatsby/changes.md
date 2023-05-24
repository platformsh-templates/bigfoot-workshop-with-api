- `composer require webonyx/graphql-php`
- Run through local dev steps, then `ddev php bin/console cache:clear`
- Run locally
- Create a basic Gatsby frontend `npm init gatsby`
- `cd bigfoot_frontend && yarn add gatsby-source-custom-api gatsby-plugin-sharp gatsby-transformer-sharp gatsby-plugin-manifest gatsby-plugin-react-helmet`
- `yarn add react-helmet react-dom react`
- You can output the resulting GraphQL schema `ddev php bin/console api:graphql:export -o schema.graphql`
- Configure the data source with the ddev graphql endpoint

```js
# bigfoot_frontend/gatsby-config.js
/**
 * @type {import('gatsby').GatsbyConfig}
 */
module.exports = {
  siteMetadata: {
    title: `bigfoot_frontend`,
    siteUrl: `https://www.yourdomain.tld`,
  },
  plugins: [
    {
      resolve: "gatsby-source-graphql",
      options: {
        // Arbitrary name for the remote schema Query type
        typeName: "Bigfoot",
        // Field under which the remote schema will be accessible. You'll use this in your Gatsby query
        fieldName: "bigFootSightings",
        // Url to query from
        url: "https://bigfoot-workshop-with-api.ddev.site/api/graphql",
      },
    },
  ],
}

```

Getting a single sighting:

```graphql
query singleSighting($id: ID!, $first: Int) {
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
```

Getting all sightings

```graphql
query allSightings($first: Int) {
  bigFootSightings(first: $first) {
      edges {
        node {
          id
          title
          description
          confidenceIndex
          latitude
          longitude
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
```


          // https://www.google.com/maps/place/21%C2%B023'57.8%22S+146%C2%B012'26.5%22E/@-21.399379,146.2047887