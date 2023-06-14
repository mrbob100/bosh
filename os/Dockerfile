FROM node:12
WORKDIR /var/www
#COPY package*.json ./
RUN npm install
# Если вы создаете сборку для продакшн
# RUN npm ci --omit=dev
EXPOSE 8080
CMD [ "npm run dev" ]
