import _ from 'lodash';
export default {
  data() {
    return {
      page: +this.$route.query.page || 1,
      pageSize: 6,
      pageCount: 0,
      allItems: [],
      breaks: [],

    }
  },
  methods: {
    pageChangeHandler(page) {
     // this.$router.push(`${this.$route.path}?page=${page}`);
      this.breaks = this.allItems[page - 1] || this.allItems[0]
    },
    setupPagination(allItems) {
      this.allItems = _.chunk(allItems, this.pageSize);
      this.pageCount = _.size(this.allItems);
      this.breaks = this.allItems[this.page - 1] || this.allItems[0]
    }
  }
}
