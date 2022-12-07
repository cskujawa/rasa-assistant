# Extend the official Rasa SDK image
FROM rasa/rasa-sdk:3.3.0

ARG user
ARG uid

# Change back to root user to install dependencies
USER root

# Create system user for jarvis
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

# To install packages from PyPI
RUN pip install --no-cache-dir requests

# Switch back to non-root to run code
USER $user