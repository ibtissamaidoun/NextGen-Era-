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

# Use the official NGINX image as base
FROM nginx:latest

# Remove the default NGINX configuration file
RUN rm /etc/nginx/conf.d/default.conf

# Copy your custom NGINX configuration file to the container
COPY nginx.conf /etc/nginx/conf.d/

# Expose port 80 for HTTP
EXPOSE 80

# Command to start NGINX
CMD ["nginx", "-g", "daemon off;"]