/**
 * Created by Vladymir on 07.12.2018.
 */
/* helpers/flash.js */
export default {

    state: {
        success: null,
        error: null
    },

    setSuccess(message)
    {
        this.state.success=message;
        setTimeout(()=>{
            this.removeSuccess()
        },3000)
    },

    setError(message)
    {
        this.state.error=message;
        setTimeout(()=>{
            this.removeError()
        },10000)
    },

    removeSuccess()
    {
        this.state.success=null
    },

    removeError()
    {
        this.state.error=null
    }
}
