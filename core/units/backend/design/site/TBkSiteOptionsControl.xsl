<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TBkSiteOptionsControl">
        <div class="site-options">
            <form method="post">
                <xsl:for-each select="options/item">
                    <xsl:variable name="option" select="."/>
                    <div class="colWidth">
                        <xsl:value-of select="title"/>
                    </div>
                    
                    <div class="colWidth">
                        <xsl:choose>
                            <xsl:when test="$option/type = 'bool'">
                                <input type="checkbox" name="{../../name/*[name()=$option/name]}">
                                    <xsl:if test="value = 1">
                                        <xsl:attribute name="checked">checked</xsl:attribute>
                                    </xsl:if>
                                </input>
                            </xsl:when>
                            <xsl:when test="$option/type = 'textarea'">
                                <textarea name="{../../name/*[name()=$option/name]}"><xsl:value-of select="value"/></textarea>
                            </xsl:when>
                            <xsl:otherwise>
                                <input type="text" name="{../../name/*[name()=$option/name]}" value="{value}"/>
                            </xsl:otherwise>
                        </xsl:choose>
                    </div>
                    <div class="clear"/>
                </xsl:for-each>
                <input type="submit" name="onBkSaveSiteOptions" value="Save Site Options"/>
            </form>
        </div>
    </xsl:template>
</xsl:stylesheet>
