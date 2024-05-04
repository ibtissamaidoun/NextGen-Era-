# Use the official NGINX image as base
FROM nginx:latest

# Remove the default NGINX configuration file
RUN rm /etc/nginx/conf.d/default.conf

# Copy your custom NGINX configuration file to the container
COPY nginx.conf /etc/nginx/conf.d/

# Expose port 80 for HTTP
EXPOSE 80

# Command to start NGINX (this is provided by the base image)
CMD ["nginx", "-g", "daemon off;"]
