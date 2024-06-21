# Stage 1: Build the Vue.js application
FROM node:lts-alpine AS build

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

# Stage 2: Use the official NGINX image as base
FROM nginx:latest

# Remove the default NGINX configuration file
RUN rm /etc/nginx/conf.d/default.conf

# Copy your custom NGINX configuration file to the container
COPY nginx.conf /etc/nginx/conf.d/

# Copy SSL certificates from the SSL folder
COPY ssl /etc/nginx/ssl

# Copy the built Vue.js application from the build stage
COPY --from=build /app/dist /usr/share/nginx/html

# Expose port 80 for HTTP and 443 for HTTPS
EXPOSE 80
EXPOSE 443

# Command to start NGINX
CMD ["nginx", "-g", "daemon off;"]