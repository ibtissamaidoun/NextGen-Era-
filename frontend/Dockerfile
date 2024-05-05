FROM node:lts-alpine

# Set working directory within the container
WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application files
COPY . .

# Build Vue.js application for production
RUN npm run build

# Command to start the server
CMD ["npm", "run", "serve"]