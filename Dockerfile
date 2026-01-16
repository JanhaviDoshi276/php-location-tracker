FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Create data directory for JSON files
RUN mkdir -p data && chmod -R 777 data

# Expose Render port
EXPOSE 10000

# Start PHP built-in server
CMD ["php", "-S", "0.0.0.0:10000"]
