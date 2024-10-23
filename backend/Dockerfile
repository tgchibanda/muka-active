# Use an official Node.js runtime as the base image
FROM node:20.12.0 as build

# Set the working directory in the container
WORKDIR /app

# Copy package.json and package-lock.json (or yarn.lock) to the working directory
COPY ../package*.json ./



# Install dependencies
RUN npm install

# Copy the entire project to the working directory
COPY . .

# Build the Vue.js application
RUN npm run build

# Use a smaller base image for serving the Vue.js application
FROM nginx:alpine

# Copy the built Vue.js files from the 'build' stage to serve the application
COPY --from=build /app/dist /usr/share/nginx/html

# Expose port 80 to the outside world
EXPOSE 80

# Start the nginx server when the container launches
CMD ["nginx", "-g", "daemon off;"]
